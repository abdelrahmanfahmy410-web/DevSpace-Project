<?php
namespace App\Http\Controllers;

use App\Models\Following;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $user       = auth()->user();
        $roleNames  = $user->roles->pluck('name')->map(fn($r) => strtolower($r))->toArray();
        $isInvestor = in_array('investor', $roleNames);

        if ($isInvestor) {
            $followingIds = Following::where('follower_id', $user->id)->pluck('following_id');
            $projects = $followingIds->isNotEmpty()
                ? Project::with(['skills', 'specializations', 'media'])
                ->whereHas('team_roles', fn($q) => $q->whereIn('user_id', $followingIds))
                ->latest()
                ->take(3)
                ->get()
                : collect();
        } else {
            $projects = Project::with(['skills', 'specializations', 'media'])
                ->whereHas('team_roles', fn($q) => $q->where('user_id', $user->id))
                ->latest()
                ->get();
        }
        if ($isInvestor) {
            $profile = $user->investor()->first() ?? null;
            $areaOfInterest = $profile?->area_of_interest;   // add this

        } else if ($user->developer()->exists()) {
            $profile = $user->developer()->with('skills')->first() ?? null;
        }
        else {
            $profile = $user->mentor()->with('skills')->first() ?? null;
        }
        $skills = $profile?->skills ?? collect();

        // if($profile==null){
        //     $profile=$user->mentor->firstorfail() ?? null;
        // }
        // if($isInvestor){
        //         $profile=$user->investor->firstorfail() ?? null;
        // }
         //dd($profile);
        $stats = [
            'my_projects'      => Project::whereHas('team_roles', fn($q) => $q->where('user_id', $user->id))->count(),
            'pending_messages' => 0,
            'followers'        => Following::where('following_id', $user->id)->count(),
            'following'        => Following::where('follower_id', $user->id)->count(),
        ];

        return view('layouts.dashboard', compact('projects', 'isInvestor', 'profile', 'stats','skills','areaOfInterest'));
    }

}
