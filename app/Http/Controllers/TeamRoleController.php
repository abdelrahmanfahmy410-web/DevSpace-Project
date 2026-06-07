<?php

namespace App\Http\Controllers;

use App\Models\TeamRole;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\DB;



class TeamRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * This shows the teammates of the authenticated user based on shared projects.
     */
    public function index()
{
   // dd(\DB::getSchemaBuilder()->getColumnListing('projects'));
    $me = auth()->user();

    // Project IDs the logged-in user is part of
    $myProjectIds = \DB::table('team_roles')
        ->where('user_id', $me->id)
        ->pluck('project_id');

    // Other users who share any of those projects
    $teammates = User::where('id', '!=', $me->id)
        ->whereExists(function ($query) use ($myProjectIds) {
            $query->select(\DB::raw(1))
                ->from('team_roles')
                ->whereColumn('team_roles.user_id', 'users.id')
                ->whereIn('team_roles.project_id', $myProjectIds);
        })
        ->get()
        ->map(function (User $user) use ($myProjectIds) {
            $sharedProjects = \DB::table('team_roles')
                ->join('projects', 'projects.id', '=', 'team_roles.project_id')
                ->where('team_roles.user_id', $user->id)
                ->whereIn('team_roles.project_id', $myProjectIds)
                ->select('projects.id', 'projects.title', 'team_roles.role')
                ->get();

            return [
                'id'       => $user->id,
                'name'     => $user->name,
                'avatar'   => $user->avatar_url ?? null,
                'headline' => $user->headline ?? null,
                'projects' => $sharedProjects,
            ];
        });

    $pageTitle = match (strtolower($me->role ?? '')) {
        'mentor'    => 'My Developers',
        'developer' => 'My Team',
        default     => 'My Team',
    };

    return view('my_team.index', compact('teammates', 'pageTitle'));
}

public function mentees()
{
    $me = auth()->user();

    // Projects where the logged-in user has the 'mentor' role
    $myMentoredProjectIds = DB::table('team_roles')
        ->where('user_id', $me->id)
        ->where('role', 'mentor')
        ->pluck('project_id');

    // Any other user on those same projects (any role)
    $mentees = User::where('id', '!=', $me->id)
        ->whereExists(function ($query) use ($myMentoredProjectIds) {
            $query->select(DB::raw(1))
                ->from('team_roles')
                ->whereColumn('team_roles.user_id', 'users.id')
                ->whereIn('team_roles.project_id', $myMentoredProjectIds);
        })
        ->get()
        ->map(function (User $user) use ($myMentoredProjectIds) {
            $sharedProjects = DB::table('team_roles')
                ->join('projects', 'projects.id', '=', 'team_roles.project_id')
                ->where('team_roles.user_id', $user->id)
                ->whereIn('team_roles.project_id', $myMentoredProjectIds)
                ->select('projects.id', 'projects.title', 'team_roles.role', 'team_roles.id as team_role_id')
                ->get();

            return [
                'id'           => $user->id,
                'team_role_id' => $sharedProjects->first()->team_role_id ?? null,
                'name'         => $user->name,
                'avatar'       => $user->avatar_url ?? null,
                'headline'     => $user->headline ?? null,
                'projects'     => $sharedProjects,
            ];
        });

    return view('mentor.mentees', compact('mentees'));
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
    public function show(TeamRole $teamRole)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeamRole $teamRole)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeamRole $teamRole)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamRole $teamRole)
    {
        //
    }
    // app/Http/Controllers/TeamRoleController.php

public function profile(TeamRole $teamRole)
{
    return match($teamRole->user_role) {
        'developer' => redirect()->route('developer.profile', $teamRole->id),
        'mentor'    => redirect()->route('developer.profile',    $teamRole->id),
        'investor'  => redirect()->route('developer.profile',  $teamRole->id),
        default     => abort(404),
    };
}
}
