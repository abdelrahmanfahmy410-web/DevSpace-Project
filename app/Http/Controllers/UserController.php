<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Search users by name or email
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(){
        return view('auth.login');
    }
 public function savelogin(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // 1. find the user by email
    $user = User::where('email', $request->email)->first();

    // 2. check if user exists with that email
    if (!$user) {
        return back()->withErrors([
            'email' => 'this email is not registered.',
        ])->withInput($request->only('email'));
    }

    // 3. check if password is correct 
    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'password' => 'the password is incorrect.',
        ])->withInput($request->only('email')); 
    }

    // 4. regenerate session and log the user in
    $request->session()->regenerate();
    Auth::login($user);
    
    return redirect('/')->with('success', 'Logged in successfully!');
}






    public function search(Request $request)
    {
      
    $q = $request->input('q', '');

    $users = User::where('name', 'LIKE', "%{$q}%")
        ->orWhere('email', 'LIKE', "%{$q}%")
        ->limit(10)
        ->get()
        ->map(fn($u) => [
            'value' => $u->id,
            'text'  => $u->name . ' (' . $u->email . ')',
        ]);

    return response()->json($users);
    }


public function showMemberProfile()
{
    $user = \App\Models\User::with([
        'roles', 
        'developer.specialization', 
        'developer.skills',
        'mentor.specialization',
        'teamProjects'
    ])->findOrFail(auth()->id());

    $userRole = $user->roles->first()->name ?? 'member';

    $skills = collect();
    if ($userRole == 'developer' && $user->developer) {
        $skills = $user->developer->skills;
    } elseif ($userRole == 'mentor' && $user->mentor) {
        $skills = $user->mentor->specialization?->skills ?? collect();
    }

    return view('member.profile', compact('user', 'userRole', 'skills'));
}

// ✅ ضيف الـ method دي جديدة
public function showOtherProfile($id)
{
    $user = \App\Models\User::with([
        'roles', 
        'developer.specialization', 
        'developer.skills',
        'mentor.specialization',
        'teamProjects'
    ])->findOrFail($id);

    $userRole = $user->roles->first()->name ?? 'member';

    $skills = collect();
    if ($userRole == 'developer' && $user->developer) {
        $skills = $user->developer->skills;
    } elseif ($userRole == 'mentor' && $user->mentor) {
        $skills = $user->mentor->specialization?->skills ?? collect();
    }

    return view('member.profile', compact('user', 'userRole', 'skills'));
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/')->with('success', 'Logged out successfully!');
}


}
