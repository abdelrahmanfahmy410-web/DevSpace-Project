<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\UserRole;
use App\Models\Role;

class InvestorController extends Controller
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
        return view('investor.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'bio' => 'nullable|string',
            'linkedin' => 'nullable|url',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'organization' => 'required|string|max:255'
        ]);
      //save img
      $imagePath = null;
      if ($request->hasFile('profile_picture')) {
        $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'bio' => $request->bio,
                'linkedin' => $request->linkedin,
                'profile_picture' => $imagePath
            ]);
           $userid=User::where('email', $request->email)->first()->id;
        Investor::create([
            'user_id' => $userid,
            'organization' => $request->organization
        ]);
        //add role to user
               UserRole::create([
                'user_id' => $userid,
                'role_id' => Role::where('name','investor')->first()->id
              ]);
              auth()->login($user);
              return redirect('/');  
    }     
    }
    /**
     * Display the specified resource.
     */
    public function show(Investor $investor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit()
{
    $user = auth()->user();
    $investor = $user->investor;
    
    return view('investor.edit', compact('user', 'investor'));
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Investor $investor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Investor $investor)
    {
        //
   
     }
public function showProfile()
{

    if (!auth()->check()) {
        return redirect()->route('login'); 
    }

    $user = auth()->user();
    
    $investor = $user->investor;
  
    if (!$investor) {
     
        return back()->with('error', 'Investor profile not found.');
    }

    return view('investor.profile', compact('user', 'investor'));
}
}
