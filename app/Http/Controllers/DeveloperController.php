<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Role;
use App\Models\Specialization;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = Specialization::all();
        return view('developer.register', compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'phone_number'      => 'nullable|string|max:20',
            'password'          => 'required|string|min:8|confirmed',
            'portfolio_url'     => 'nullable|url',
            'bio'               => 'nullable|string',
            'linkedin_url'      => 'nullable|url',
            'profile_picture'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        try {
            DB::beginTransaction();
            $imagname = null;

            if ($request->hasFile('profile_picture')) {
                $imagname = $request->file('profile_picture')->store('profiles', 'public');
            }

            // create user
            $user = User::create([
                'name'            => $validatedData['name'],
                'email'           => $validatedData['email'],
                'phonenumber'     => $validatedData['phone_number'] ?? null,
                'bio'             => $validatedData['bio'] ?? null,
                'linkedin_url'    => $validatedData['linkedin_url'] ?? null,
                'profile_picture' => $imagname,
                'password'        => Hash::make($validatedData['password']),
            ]);

            // create developer
            Developer::create([
                'user_id'           => $user->id,
                'portfolio_url'     => $validatedData['portfolio_url'] ?? null,
                'specialization_id' => $validatedData['specialization_id'],
            ]);

            DB::commit();

            auth()->login($user);
            
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => Role::where('name', 'developer')->first()->id,
            ]);

            return redirect('/member/profile')
                ->with('success', 'Developer account created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id = null)
    {
        // إذا لم يتم إرسال ID، يعرض بروفايل المستخدم الحالي المسجل
        $userId = $id ?? auth()->id();
        
        $developer = Developer::with(['user', 'specialization'])->where('user_id', $userId)->first();

        if (!$developer) {
            return "تنبيّه: هذا المطور غير موجود أو جدول المطورين فارغ.";
        }

        return view('developer.profile', compact('developer'));
    }

    /**
     * Show the profile details for the logged-in user.
     */
    public function myprojectdetails()
    {
        // يفضل مستقبلاً جعل هذه الدالة مخصصة لعرض مشاريع المطور المسجل فقط 
        $userId = auth()->id();
        $developer = Developer::with(['user', 'specialization'])->where('user_id', $userId)->first();

        if (!$developer) {
            return "جدول المطورين (developers) فارغ في قاعدة البيانات. برجاء إضافة مطور أولاً للتجربة.";
        }

        return view('developer.profile', compact('developer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        try {
            // جلب بيانات المطور المسجل حالياً فقط لحمايتها وأمانها
            $developer = Developer::with('user')->where('user_id', auth()->id())->first();
            
            if (!$developer) {
                return "تنبيه: لا توجد بيانات مطور مرتبطة بحسابك الحالي لتعديلها.";
            }
            
            $specializations = Specialization::all();
            return view('developer.edit', compact('developer', 'specializations'))->render();

        } catch (\Exception $e) {
            return response()->json([
                'message'       => 'حصلت مشكلة أثناء فتح صفحة التعديل',
                'error_details' => $e->getMessage(),
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            // جلب بيانات المطور الحالي المسجل لحماية البيانات من التعديل العشوائي
            $developer = Developer::with('user')->where('user_id', auth()->id())->first();

            if (!$developer || !$developer->user) {
                return redirect()->back()->withErrors(['error' => 'بيانات المطور أو المستخدم غير متوفرة لحسابك']);
            }

            // التحقق من البيانات القادمة من الفورم (Validation)
            $validatedData = $request->validate([
                'phone_number'      => 'nullable|string|max:20',
                'bio'               => 'nullable|string',
                'profile_picture'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'specialization_id' => 'required|exists:specializations,id',
                'portfolio_url'     => 'nullable|url',
                'linkedin_url'      => 'nullable|url',
            ]);

            // تجميع وتحديث بيانات جدول الـ USERS
            $userData = [
                'phonenumber' => $request->phone_number, // تأكد هل اسم العمود بالـ DB هو phonenumber أو phone_number
                'bio'          => $request->bio,
            ];

            if ($request->hasFile('profile_picture')) {
                $userData['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
            }

            $developer->user->update($userData);

            // تحديث بيانات جدول الـ DEVELOPERS
            $developer->update([
                'specialization_id' => $request->specialization_id,
                'portfolio_url'     => $request->portfolio_url,
                'linkedin_url'      => $request->linkedin_url,
            ]);

            return redirect()->route('developer.profile')->with('success', 'تم تحديث البروفايل بنجاح!');

        } catch (\Exception $e) {
            return response()->json([
                'message'       => 'حدث خطأ أثناء حفظ البيانات في جدول اليوزر والمطور',
                'error_details' => $e->getMessage(),
                'file'          => $e->getFile(),
                'line'          => $e->getLine(),
            ], 500);
        }
    }

    /**
     * List all developers with filters and pagination.
     */
    public function allDevelopers(Request $request)
    {
        // 1. بناء الاستعلام الأساسي مع العلاقات
        $query = Developer::with(['user', 'specialization', 'skills']);

        // 2. تطبيق الفلاتر بناءً على الـ Request أولاً
        // فلتر البحث بالاسم
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // فلتر التخصص
        if ($request->filled('specialization')) {
            $query->whereHas('specialization', function ($q) use ($request) {
                $q->whereIn('name', (array) $request->specialization);
            });
        }

        // فلتر المهارات
        if ($request->filled('skills')) {
            $query->whereHas('skills', function ($q) use ($request) {
                $q->whereIn('name', (array) $request->skills);
            });
        }

        // 3. تشغيل التصفح وجلب البيانات (Pagination) مع الاحتفاظ بالفلاتر بالرابط
        $developersPaginator = $query->paginate(9)->withQueryString();

        // 4. تعديل شكل البيانات الداخلي (Map) الموجه للـ View مرة واحدة فقط
        $developersPaginator->setCollection(
            $developersPaginator->getCollection()->map(function ($dev) {
                return [
                    'id'             => $dev->user?->id ?? null,
                    'name'           => $dev->user?->name ?? 'Unknown Developer',
                    'avatar'         => $dev->user?->profile_picture
                        ? asset('storage/' . $dev->user->profile_picture)
                        : 'https://via.placeholder.com/150',
                    'specialization' => $dev->specialization?->name ?? 'General',
                    'bio'            => $dev->user?->bio ?? 'No bio available.',
                    'skills'         => $dev->skills->pluck('name')->toArray(),
                ];
            })
        );

        // 5. جلب بيانات الفلاتر المعروضة بالـ Sidebar بالصفحة
        $specializations = Specialization::whereNotNull('name')->pluck('name');
        $skills          = Skill::pluck('name');

        return view('developer.all_developers', [
            'developers'      => $developersPaginator,
            'specializations' => $specializations,
            'skills'          => $skills,
        ]);
    }
}