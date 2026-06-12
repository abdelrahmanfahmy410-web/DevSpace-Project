<?php

namespace App\Http\Controllers;

use App\Models\Following;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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



public function show(Request $request)
{
    // 1. جلب الأشخاص المتابعين لي (بدون تحميل علاقة المهارات المسببة للمشكلة)
    $query = Following::where('following_id', auth()->id())->with('follower');

    // 2. تطبيق البحث
    if ($request->filled('search')) {
        $searchTerm = $request->search;
        $query->whereHas('follower', function ($q) use ($searchTerm) {
            $q->where('name', 'LIKE', "%{$searchTerm}%")
              ->orWhere('username', 'LIKE', "%{$searchTerm}%");
        });
    }

    // 3. الترتيب الأبجدي
    if ($request->sort === 'alpha') {
        $query->join('users', 'followings.follower_id', '=', 'users.id')
              ->orderBy('users.name', 'asc')
              ->select('followings.*');
    }

    $followers = $query->paginate(9);

    // 4. تحديد المتابعة المتبادلة Mutual
    $followingIds = Following::where('follower_id', auth()->id())
                        ->pluck('following_id')
                        ->toArray();

    return view('my-followers', [
        'followers'    => $followers,
        'followingIds' => $followingIds,
    ]);
}
public function remove($id)
{
    Following::where('follower_id', $id)
              ->where('following_id', auth()->id())
              ->delete();

    return back()->with('success', 'Follower removed.');
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
}
