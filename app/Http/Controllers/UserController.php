<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
public function savelogin(Request $request){

// Validate the incoming request data
 $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        Auth::login($user);
        return redirect('/dashboard');
    }



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
}
