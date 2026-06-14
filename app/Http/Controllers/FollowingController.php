<?php

namespace App\Http\Controllers;

use App\Models\Following;
use App\Models\User;
use Illuminate\Http\Request;

class FollowingController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Following $following)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Following $following)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Following $following)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Following $following)
    {
        //
    }
public function toggleFollow(User $user)
{
    // نتأكد هل فيه يوزر عامل login؟
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
    }

    // لو دخل هنا، معناه إن اليوزر موجود ومسجل دخول
    auth()->user()->following()->toggle($user->id);

    return back();
}


}
