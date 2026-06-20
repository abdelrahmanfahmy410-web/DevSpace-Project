<?php

namespace App\Http\Controllers;

use App\Models\Following;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class FollowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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



    public function toggleFollow(User $user)
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
    }

    // toggle() بيرجع array فيه 'attached' و 'detached'
    $result = auth()->user()->following()->toggle($user->id);

    $isNowFollowing = !empty($result['attached']);
    $message = $isNowFollowing
        ? 'You are now following ' . $user->name
        : 'You have unfollowed ' . $user->name;

    return back()->with('follow_status', $message);
}


public function show(Request $request)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $authId = auth()->id();

    // الناس اللي بيتبعوك
    $followersQuery = Following::where('following_id', $authId)->with('follower.developer.specialization');

    // الناس اللي بتتبعهم
    $followingQuery = Following::where('follower_id', $authId)->with('following.developer.specialization');

    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $followersQuery->whereHas('follower', fn($q) => $q->where('name', 'LIKE', "%{$searchTerm}%")->orWhere('username', 'LIKE', "%{$searchTerm}%"));
        $followingQuery->whereHas('following', fn($q) => $q->where('name', 'LIKE', "%{$searchTerm}%")->orWhere('username', 'LIKE', "%{$searchTerm}%"));
    }

    $followers = $followersQuery->get();
    $following = $followingQuery->get();

    // IDs الناس اللي بتتبعهم (عشان نعرف مين mutual)
    $followingIds = $following->pluck('following_id')->toArray();

    return view('my-followers', compact('followers', 'following', 'followingIds'));
}

public function remove($id)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    Following::where('follower_id', $id)
              ->where('following_id', auth()->id())
              ->delete();

    return back()->with('success', 'The follower was successfully removed.');
}

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
