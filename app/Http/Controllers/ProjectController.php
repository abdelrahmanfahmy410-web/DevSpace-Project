<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Specialization;
use App\Models\TeamRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $types             = $request->input('type', []);
        $specializationIds = $request->input('specialization', []);
        $skillIds          = $request->input('skills', []);
        $sort              = $request->input('sort', 'newest');

        $projects = Project::with(['skills', 'specializations', 'media'])
            ->when($types, fn($q) => $q->whereIn('type', $types))
            ->when($specializationIds, fn($q) => $q->whereHas('specializations',
                fn($q2) => $q2->whereIn('specializations.id', $specializationIds)
            ))
            ->when($skillIds, fn($q) => $q->whereHas('skills',
                fn($q2) => $q2->whereIn('skills.id', $skillIds)
            ))
            ->when($sort, function($q, $sort) {
                match($sort) {
                    'oldest' => $q->oldest(),
                    'az'     => $q->orderBy('title'),
                    default  => $q->latest(),
                };
            })
            ->paginate(9)
            ->withQueryString();

        $specializations = \App\Models\Specialization::orderBy('name')->get();
        $skills          = \App\Models\Skill::orderBy('name')->get();

        return view('Project.projects-index', compact('projects', 'specializations', 'skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = \App\Models\Specialization::all();
        $skills = [];
        return view('project.add_project', compact('specializations', 'skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'                  => 'required|string|max:255',
            'description'            => 'required|string',
            'type'                   => 'required|string|max:100',
            'specializations'        => 'required|array',
            'specializations.*'      => 'exists:specializations,id',
            'skills'                 => 'nullable|array',
            'skills.*'               => 'exists:skills,id',
            'project_images'         => 'nullable|array',
            'project_images.*'       => 'image|mimes:jpeg,png,jpg,gif,svg',
            'team_members'           => 'nullable|array',
            'team_members.*.user_id' => 'required|exists:users,id',
            'team_members.*.role'    => 'required|string',
        ]);

        $project = Project::create([
            'title'           => $request->title,
            'description'     => $request->description,
            'repository_link' => $request->repository_link,
            'live_demo_link'  => $request->live_demo_link,
            'type'            => $request->type,
        ]);

        // Upload images
        if ($request->hasFile('project_images')) {
            foreach ($request->file('project_images') as $image) {
                $path = $image->store('projects_media', 'public');
                $project->media()->create([
                    'file_path' => $path,
                    'medianame' => $image->getClientOriginalName(),
                ]);
            }
        }

        // Attach specializations
        $project->specializations()->attach($request->specializations);

        // Attach skills
        if ($request->has('skills')) {
            $project->skills()->attach($request->skills);
        }

        // Attach team members
        if ($request->has('team_members') && !empty($request->team_members)) {
            foreach ($request->team_members as $member) {
                $project->team_roles()->attach($member['user_id'], [
                    'role' => $member['role']
                ]);
            }
        }

        // Ensure the creator is added to the team
        if (!$project->team_roles()->where('user_id', auth()->id())->exists()) {
            $project->team_roles()->attach(auth()->id(), [
                'role' => 'Project Creator'
            ]);
        }

        return redirect()->route('projects.my')->with('success', 'Project added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['skills', 'specializations', 'team_roles', 'media', 'watchers']);
        return view('Project.project_details', compact('project'));
    }

     
     public function showmyProjectDetails(Project $project)
{
    // // 1. التحقق من الصلاحية: هل المستخدم الحالى هو صاحب المشروع؟
    // if ($project->user_id !== auth()->user()->id) {
    //     abort(403) ;
    // }

    // 2. تحميل العلاقات الخاصة بالمشروع لتعرض في الصفحة
    $project->load(['skills', 'specializations', 'team_roles', 'media', 'watchers']);

    // 3. التوجه إلى صفحة العرض وتمرير المتغير
    return view('Project.my_project_details', compact('project'));
}
   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $specializations = Specialization::all();
        $project->load(['skills', 'specializations', 'media']);
        return view('project.edit_project', compact('project', 'specializations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title'                  => 'required|string|max:255',
            'description'            => 'required|string',
            'type'                   => 'required|string|max:100',
            'specializations'        => 'required|array',
            'specializations.*'      => 'exists:specializations,id',
            'skills'                 => 'nullable|array',
            'skills.*'               => 'exists:skills,id',
            'project_images'         => 'nullable|array',
            'project_images.*'       => 'image|mimes:jpeg,png,jpg,gif,svg',
            'team_members'           => 'nullable|array',
            'team_members.*.user_id' => 'required|exists:users,id',
            'team_members.*.role'    => 'required|string',
        ]);

        $project->update([
            'title'           => $request->title,
            'description'     => $request->description,
            'repository_link' => $request->repository_link,
            'live_demo_link'  => $request->live_demo_link,
            'type'            => $request->type,
        ]);

        // Update images
        if ($request->hasFile('project_images')) {
            foreach ($project->media as $media) {
                Storage::disk('public')->delete($media->file_path);
                $media->delete();
            }
            foreach ($request->file('project_images') as $image) {
                $newPath = $image->store('projects_media', 'public');
                $project->media()->create([
                    'file_path' => $newPath,
                    'medianame' => $image->getClientOriginalName(),
                ]);
            }
        }

        $project->specializations()->sync($request->specializations);
        $project->skills()->sync($request->skills ?? []);

        // Update team members
        if ($request->has('team_members')) {
            $project->team_roles()->detach();
            foreach ($request->team_members as $member) {
                $project->team_roles()->attach($member['user_id'], [
                    'role' => $member['role']
                ]);
            }
        }

        return redirect()->route('projects.index')->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($project->media()->exists()) {
            foreach ($project->media as $media) {
                Storage::disk('public')->delete($media->file_path);
            }
        }
        $project->delete();
        return redirect()->back()->with('success', 'Project deleted successfully');
    }

    /**
     * Get skills by specialization (AJAX)
     */
    public function getSkillsBySpecialization(Specialization $specialization)
    {
        $skills = $specialization->skills;
        return response()->json($skills);
    }
    public function assignedProjects()
    {
        $userId = auth()->id();
        $projects = Project::whereHas('team_roles', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with(['skills', 'specializations', 'team_roles','media'])->get();

        return view('project.assigned_projects',compact('projects'));
    }

    /**
     * Search users for team member selection (AJAX)
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q', '');

        $users = \App\Models\User::where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->limit(10)
                    ->get(['id as value', 'name as text']);

        return response()->json($users);
    }

    public function show_projects($id)
    {
        $project = Project::with(['skills', 'specializations', 'team_roles'])->findOrFail($id);
        return view('projects_show', compact('project'));
    }

    /**
     * Display projects assigned to the current user via team roles.
     */
    public function myProjects()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $projects = Project::whereHas('team_roles', function($query) {
            $query->where('user_id', auth()->id());
        })->latest()->get();

        return view('Project.my-projects', compact('projects'));
    }

    public function addMedia(Project $project)
    {
        return view('project.add_media', compact('project'));
    }

    /**
     * Toggle project wishlist status (AJAX)
     */
    public function toggleWishlist(Project $project)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = auth()->user();
        $status = $user->wishlist()->toggle($project->id);
        $attached = count($status['attached']) > 0;

        return response()->json([
            'success' => true,
            'attached' => $attached
        ]);
    }

    /**
     * Display user's wishlist
     */
    public function wishlist()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $projects = auth()->user()->wishlist()
            ->with(['skills', 'specializations', 'media'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $specializations = \App\Models\Specialization::orderBy('name')->get();
        $skills = \App\Models\Skill::orderBy('name')->get();

        return view('Project.wishlist', compact('projects', 'specializations', 'skills'));
    }

    /**
     * Redirect to member profile based on role
     */
    public function memberProfile(TeamRole $teamRole)
    {
        return match($teamRole->user->role) {
            'developer' => redirect()->route('developer.profile', $teamRole->user->id),
            'mentor'    => redirect()->route('developer.profile', $teamRole->user->id),
            'investor'  => redirect()->route('developer.profile', $teamRole->user->id),
            default     => abort(404),
        };
    }
}