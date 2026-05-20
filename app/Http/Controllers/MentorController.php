<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MentorController extends Controller
{
    public function index()
    {
        //
        $mentors = Mentor::with('user')->get();
        return view('mentor.register', compact('mentors'));
    }

    public function create()
    {
        return view('mentor.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|string|min:8|confirmed',
            'organization'     => 'nullable|string|max:255',
            'experience_years' => 'required|integer|min:0|max:30',
            'phone'            => 'nullable|string|max:20',
            'bio'              => 'nullable|string|max:1000',
            'linkedin_url'     => 'nullable|url|max:255',
            'profile_picture'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'bio'      => $request->bio,
            'linkedin_url'     => $request->linkedin_url,
            'phonenumber'      => $request->phone

        ]);

        $mentorData = [
            'user_id'          => $user->id,
            'experience_years' => $request->experience_years,
            'organization'     => $request->organization,
            'specialization_id' => null
        ];

        if ($request->hasFile('profile_picture')) {
            $mentorData['profile_picture'] = $request->file('profile_picture')->store('mentors/profiles', 'public');
        }

        Mentor::create($mentorData);

        return redirect()->route('mentor.register')->with('success', 'Registered successfully!');
    }

    public function show(Mentor $mentor)
    {
        //
    }

    public function edit(Mentor $mentor)
    {
        //
    }

    public function update(Request $request, Mentor $mentor)
    {
        //
    }

    public function destroy(Mentor $mentor)
    {
        //
    }
}