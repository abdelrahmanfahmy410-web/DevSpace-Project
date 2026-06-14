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
    $id = auth()->id();
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

    $specializationId = $user->developer->specialization_id
                     ?? $user->mentor->specialization_id
                     ?? null;

    $suggestions = collect();

    if ($specializationId) {
        $suggestions = \App\Models\User::where('id', '!=', $user->id)
            ->where('id', '!=', auth()->id())
            ->where(function ($q) use ($specializationId) {
                $q->whereHas('developer', fn($d) =>
                    $d->where('specialization_id', $specializationId)
                )
                ->orWhereHas('mentor', fn($m) =>
                    $m->where('specialization_id', $specializationId)
                );
            })
            ->with(['developer.specialization', 'mentor.specialization'])
            ->limit(5)
            ->get();
    }
    return view('member.profile', compact('user', 'userRole', 'skills', 'suggestions'));
}




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

    $specializationId = $user->developer->specialization_id
                     ?? $user->mentor->specialization_id
                     ?? null;

    $suggestions = collect();

    if ($specializationId) {
        $suggestions = \App\Models\User::where('id', '!=', $user->id)
            ->where('id', '!=', auth()->id())
            ->where(function ($q) use ($specializationId) {
                $q->whereHas('developer', fn($d) =>
                    $d->where('specialization_id', $specializationId)
                )
                ->orWhereHas('mentor', fn($m) =>
                    $m->where('specialization_id', $specializationId)
                );
            })
            ->with(['developer.specialization', 'mentor.specialization'])
            ->limit(5)
            ->get();
    }
    return view('member.profile', compact('user', 'userRole', 'skills', 'suggestions'));
}


public function logout()
{
    Auth::logout();
    return redirect('/login');
}


}
