<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Specialization;
use App\Models\UserRole;
use App\Models\Role;

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
  //  dd('here');
    return view('developer.register');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone_number' => 'nullable|string|max:20',
        'password' => 'required|string|min:8|confirmed',
        'portfolio_url' => 'nullable|url',
        'bio' => 'nullable|string',
        'linkedin_url' => 'nullable|url',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phonenumber' => $validatedData['phone_number'] ?? null,
            'bio' => $validatedData['bio'] ?? null,
            'linkedin_url' => $validatedData['linkedin_url'] ?? null,
            'profile_picture' => $imagname,
            'password' => Hash::make($validatedData['password']),
            
        ]);

        // create developer
        Developer::create([
            'user_id' => $user->id,
            'portfolio_url' => $validatedData['portfolio_url'] ?? null,
            'specialization_id' => $validatedData['specialization_id'],
        ]);

        DB::commit();
       
        auth()->login($user);
        UserRole::create([
                'user_id' => $user->id,
                'role_id' => Role::where('name','developer')->first()->id
          ]);
        return redirect('/developer/profile')
            ->with('success', 'Developer account created successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withErrors([
                'error' => $e->getMessage()
            ])
            ->withInput();
    }
}

   
public function show()
{ 
    $developer = Developer::with(['user', 'specialization'])->first();
   //  dd($developer->user->roles());
    if (!$developer) {
        return "جدول المطورين (developers) فارغ في قاعدة البيانات. برجاء إضافة مطور أولاً للتجربة.";
    }

    return view('developer.profile', compact('developer'));
}
 public function edit()
{try {
        // جلب أول مطور من الداتابيز مع المستخدم بتاعه عشان التست يشتغل علطول حتى لو مش عاملة Login
        $developer = \App\Models\Developer::with('user')->first();

        if (!$developer) {
            return "تنبيه: لا يوجد أي مطور في قاعدة البيانات لتعديله.";
        }

        // جلب كل التخصصات عشان يقدر يختار منها في الـ Select Box
        $specializations = \App\Models\Specialization::all();

        // تجربة رندر لملف الـ Blade عشان لو جواه غلطة نمسكها هنا
        return view('developer.edit', compact('developer', 'specializations'))->render();

    } catch (\Exception $e) {
        // طباعة تفاصيل الخطأ الحقيقي فوراً في المتصفح بدل الـ 500 Error
        return response()->json([
            'message' => 'حصلت مشكلة أثناء فتح صفحة التعديل',
            'error_details' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
}
    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request)

{   try {
        // 1. جلب المطور مع اليوزر المرتبط بيه
        $developer = \App\Models\Developer::with('user')->first();

        if (!$developer || !$developer->user) {
            return "تنبيه: لا يوجد مطور أو مستخدم مرتبط به في قاعدة البيانات لتحديثه";
        }

        // 2. التحقق من البيانات القادمة من الفورم (Validation)
        $validatedData = $request->validate([
            // حقول مكانها جدول الـ users
            'phone_number' => 'nullable|string|max:20',
            'bio' => 'nullable|string', 
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // اسم الـ input في الـ Form

            // حقول مكانها جدول الـ developers
            'specialization_id' => 'required|exists:specializations,id',
            'portfolio_url' => 'nullable',
            'linkedin_url' => 'nullable',
        ]);

        // 3. تجميع وتحديث بيانات جدول الـ USERS (الاسم، التليفون، البايو، الصورة)
        $userData = [
            'phone_number' => $request->phone_number,
            'bio' => $request->bio, // حفظ البايو جوة جدول الـ users هنا
        ];
        dd($request->all());
        if ($request->hasFile('profile_picture')) {
            // رفع الصورة وحفظ المسار في حقل 'profile_pic' التابع لليوزر
            $userData['profile_pic'] = $request->file('profile_picture')->store('profiles', 'public');
        }

        $developer->user->update($userData);

        // 4. تحديث بيانات جدول الـ DEVELOPERS (التخصص والروابط فقط)
        $developer->update([
            'specialization_id' => $request->specialization_id,
            'portfolio_url' => $request->portfolio_url,
            'linkedin_url' => $request->linkedin_url,
        ]);

        // 5. التوجيه لصفحة البروفايل بنجاح
        return redirect()->route('developer.profile')->with('success', 'تم تحديث البروفايل بنجاح!');

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'حدث خطأ أثناء حفظ البيانات في جدول اليوزر والمطور',
            'error_details' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ], 500);
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Developer $developer)
    {
        //
    }
}
