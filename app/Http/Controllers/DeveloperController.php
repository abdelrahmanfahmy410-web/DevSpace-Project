<?php
namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Role;
use App\Models\Specialization;
use App\Models\User;
use App\Models\UserRole;
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

    public function show()
    {
        $userid    = auth()->id();
        $developer = Developer::with(['user', 'specialization'])->where('user_id', $userid)->first();
        //  dd($developer->user->roles());
        if (! $developer) {
            return "جدول المطورين (developers) فارغ في قاعدة البيانات. برجاء إضافة مطور أولاً للتجربة.";
        }

        return view('developer.profile', compact('developer'));
    }
    public function myprojectdetails()
    {
        $user_id   = auth()->user()->id;
        $developer = Developer::with(['user', 'specialization'])->where('user_id', $user_id)->first();
        //  dd($developer->user->roles());
        if (! $developer) {
            return "جدول المطورين (developers) فارغ في قاعدة البيانات. برجاء إضافة مطور أولاً للتجربة.";
        }

        return view('developer.profile', compact('developer'));
    }
    public function edit()
    {
        try {
            $developer = \App\Models\Developer::with('user')->first();
            if (! $developer) {
                return "تنبيه: لا يوجد أي مطور في قاعدة البيانات لتعديله.";
            }
            $specializations = \App\Models\Specialization::all();
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
            // 1. جلب المطور مع اليوزر المرتبط بيه
            $developer = \App\Models\Developer::with('user')->first();

            if (! $developer || ! $developer->user) {
                return redirect()->back()->withErrors(['error' => 'المطور أو المستخدم غير موجود']);
            }

            // 2. التحقق من البيانات القادمة من الفورم (Validation)
            $validatedData = $request->validate([
                'phone_number'      => 'nullable|string|max:20',
                'bio'               => 'nullable|string',
                'profile_picture'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'specialization_id' => 'required|exists:specializations,id',
                'portfolio_url'     => 'nullable',
                'linkedin_url'      => 'nullable',
            ]);

            // 3. تجميع وتحديث بيانات جدول الـ USERS
            $userData = [
                'phone_number' => $request->phone_number,
                'bio'          => $request->bio,
            ];

            if ($request->hasFile('profile_picture')) {
                $userData['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
            }

            $developer->user->update($userData);

            // 4. تحديث بيانات جدول الـ DEVELOPERS
            $developer->update([
                'specialization_id' => $request->specialization_id,
                'portfolio_url'     => $request->portfolio_url,
                'linkedin_url'      => $request->linkedin_url,
            ]);

            // 5. التوجيه لصفحة البروفايل بنجاح
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
    $query = Developer::with(['user', 'specialization', 'skills']);

    // فلتر الاسم
    if ($request->filled('search')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    // فلتر التخصص
    if ($request->filled('specialization')) {
        $query->whereHas('specialization', function ($q) use ($request) {
            $q->whereIn('name', $request->specialization);
        });
    }

    // فلتر السكيلز
    if ($request->filled('skills')) {
        $query->whereHas('skills', function ($q) use ($request) {
            $q->whereIn('name', $request->skills);
        });
    }

    $developersPaginator = $query->paginate(9)->withQueryString();

    $developersPaginator->setCollection(
        $developersPaginator->getCollection()->map(function ($dev) {
            return [
                'id'             => $dev->user?->id ?? $dev->id,
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

    $specializations = \App\Models\Specialization::whereNotNull('name')->pluck('name');
    $skills          = \App\Models\Skill::pluck('name');

    return view('developer.all_developers', [
        'developers'      => $developersPaginator,
        'specializations' => $specializations,
        'skills'          => $skills,
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
