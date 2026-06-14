<?php

namespace App\Http\Controllers;

use App\Models\TeamRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TeamRoleController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));
        $perPage = 12;

        $user = auth()->user();

        $projectIds = TeamRole::where('user_id', $user->id)->pluck('project_id');

        $teammates = TeamRole::with(['user.roles', 'project'])
            ->whereIn('project_id', $projectIds)
            ->where('user_id', '!=', $user->id)
            ->get()
            ->groupBy('user_id')
            ->map(function ($roles) {
                $u = $roles->first()->user;

                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'avatar' => $u->avatar ?? null,
                    'headline' => $u->headline ?? null,
                    'roles' => $roles->pluck('role')->unique()->map(fn ($r) => strtolower($r))->implode(','),
                    'projects' => $roles->map(fn ($r) => (object) [
                        'id' => $r->project->id,
                        'title' => $r->project->title,
                        'role' => $r->role,
                    ]),
                ];
            })
            ->values();

        if ($query !== '') {
            $lower = strtolower($query);
            $teammates = $teammates->filter(function ($t) use ($lower) {
                $words = preg_split('/\s+/', strtolower($t['name'].' '.($t['headline'] ?? '')));

                return collect($words)->contains(fn ($w) => str_starts_with($w, $lower));
            })->values();
        }

        $total = $teammates->count();

        $allRoles = $teammates
            ->flatMap(fn ($t) => explode(',', $t['roles']))
            ->filter()
            ->unique()
            ->sort()
            ->values();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $pageItems = $teammates->slice(($page - 1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator($pageItems, $total, $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        return view('my_team.index', [
            'teammates' => $paginator,
            'pageTitle' => 'My Team',
            'query' => $query,
            'total' => $total,
            'roles' => $allRoles,
        ]);
    }

    public function mentees()
    {
        $me = auth()->user();

        $myMentoredProjectIds = DB::table('team_roles')
            ->where('user_id', $me->id)
            ->where('role', 'mentor')
            ->pluck('project_id');

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
                    'id' => $user->id,
                    'team_role_id' => $sharedProjects->first()->team_role_id ?? null,
                    'name' => $user->name,
                    'avatar' => $user->avatar_url ?? null,
                    'headline' => $user->headline ?? null,
                    'projects' => $sharedProjects,
                ];
            });

        $total = $mentees->count();

        return view('mentor.mentees', compact('mentees', 'total'));
    }



    //accept and reject team role invitations //

    public function accept(TeamRole $teamRole)
    {
        if ($teamRole->user_id !== auth()->id()) {
            abort(403);
        }

        $teamRole->update(['status' => 'approved']);

        return back()->with('success', 'Project approved successfully!');
    }

    public function reject(TeamRole $teamRole)
    {
        if ($teamRole->user_id !== auth()->id()) {
            abort(403);
        }

        $teamRole->update(['status' => 'rejected']);

        return back()->with('success', 'Project rejected successfully!');
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
        return match ($teamRole->user_role) {
            'developer' => redirect()->route('developer.profile', $teamRole->id),
            'mentor' => redirect()->route('developer.profile', $teamRole->id),
            'investor' => redirect()->route('developer.profile', $teamRole->id),
            default => abort(404),
        };
    }
}
