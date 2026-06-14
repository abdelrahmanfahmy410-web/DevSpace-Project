<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Role;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_projects' => Project::count(),
            'total_specializations' => Specialization::count(),
            'new_this_month' => User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
            'top_projects' => Project::orderByDesc('views')->take(5)->get(['title', 'views']),
            'users_by_role' => DB::table('user_roles')
                ->join('roles', 'roles.id', '=', 'user_roles.role_id')
                ->select('roles.name as role_name', DB::raw('count(*) as total'))
                ->groupBy('roles.name')
                ->get(),
            'signups_by_month' => User::selectRaw("DATE_FORMAT(created_at, '%b %Y') as month, DATE_FORMAT(created_at, '%Y-%m') as sort_key, COUNT(*) as total")
                ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
                ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m'), DATE_FORMAT(created_at, '%b %Y')")
                ->orderByRaw("DATE_FORMAT(created_at, '%Y-%m')")
                ->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phonenumber', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('roles.id', $request->role);
            });
        }

        if ($request->filled('verified')) {
            $request->verified === 'yes'
                ? $query->whereNotNull('email_verified_at')
                : $query->whereNull('email_verified_at');
        }

        $users = $query->select('id', 'name', 'email', 'phonenumber', 'profile_picture', 'email_verified_at', 'created_at')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $roles = Role::select('id', 'name')->get();

        return view('admin.all_users', compact('users', 'roles'));
    }

    public function projects(Request $request)
{
    $query = Project::with(['team_roles', 'skills', 'specializations'])
                    ->select('id', 'title', 'description', 'type', 'views',
                             'repository_link', 'live_demo_link', 'created_at');

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', "%{$request->search}%")
              ->orWhere('description', 'like', "%{$request->search}%");
        });
    }

    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    if ($request->filled('specialization')) {
        $query->whereHas('specializations', function ($q) use ($request) {
            $q->where('specializations.id', $request->specialization);
        });
    }

    match($request->get('sort', 'latest')) {
        'views'  => $query->orderByDesc('views'),
        'oldest' => $query->oldest(),
        default  => $query->latest(),
    };

    $projects        = $query->paginate(9)->withQueryString();
    $types           = Project::select('type')->distinct()->pluck('type');
    $specializations = Specialization::select('id', 'name')->orderBy('name')->get();

    return view('admin.projects', compact('projects', 'types', 'specializations'));
}
public function showProject(Project $project)
{
    $project->load(['team_roles', 'skills', 'specializations', 'media']);
    return view('admin.project-show', compact('project'));
}
}
