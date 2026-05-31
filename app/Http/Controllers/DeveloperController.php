<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Specialization;


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

        // create user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // upload image
        $imagePath = null;

        if ($request->hasFile('profile_picture')) {
            $imagePath = $request->file('profile_picture')->store('profiles', 'public');
        }

        // create developer
        Developer::create([
            'user_id' => $user->id,
            'portfolio_url' => $validatedData['portfolio_url'] ?? null,
            'bio' => $validatedData['bio'] ?? null,
            'linkedin_url' => $validatedData['linkedin_url'] ?? null,
            'phone_number' => $validatedData['phone_number'] ?? null,
            'profile_picture' => $imagePath,
            'specialization_id' => $validatedData['specialization_id'],
        ]);

        DB::commit();

        auth()->login($user);

        return redirect('/investor/register')
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

    /**
     * Display the specified resource.


     * Show the form for editing the specified resource.
//      */

public function show()
{ 
    $developer = Developer::with(['user', 'specialization'])->first();

    if (!$developer) {
        return "جدول المطورين (developers) فارغ في قاعدة البيانات. برجاء إضافة مطور أولاً للتجربة.";
    }

    return view('developer.profile', compact('developer'));
}
 public function edit()
{
    $user = auth()->user()->load('developer');
    $specializations = Specialization::all(); 

    return view('developer.edit', compact('user', 'specializations'));
}
    /**
     * Update the specified resource in storage.
     */
 public function update(Request $request)
{
    $developer = auth()->user()->developer;

    $validatedData = $request->validate([
        'portfolio_url' => 'nullable|url',
        'bio' => 'nullable|string',
        'linkedin_url' => 'nullable|url',
        'phone_number' => 'nullable|string|max:20',
        'specialization_id' => 'required|exists:specializations,id',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // لو رفع صورة جديدة، امسحي القديمة وخزني الجديدة
    if ($request->hasFile('profile_picture')) {
        $validatedData['profile_picture'] = $request->file('profile_picture')->store('profiles', 'public');
    }

    // تحديث البيانات في الجدول
    $developer->update($validatedData);

    return redirect()->route('developer.profile')->with('success', 'تم تحديث البروفايل بنجاح');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Developer $developer)
    {
        //
    }
}
