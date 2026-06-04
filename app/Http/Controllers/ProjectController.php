<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Specialization;
use App\Models\team_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $specializationId = $request->input('specialization');
    $skillId          = $request->input('skill');
    $type             = $request->input('type');
    $sort             = $request->input('sort', 'newest');

    $projects = Project::with(['skills', 'specializations', 'media'])
        ->when($type, fn($q) => $q->where('type', $type))
        ->when($specializationId, fn($q) => $q->whereHas('specializations',
            fn($q2) => $q2->where('specializations.id', $specializationId)
        ))
        ->when($skillId, fn($q) => $q->whereHas('skills',
            fn($q2) => $q2->where('skills.id', $skillId)
        ))
        ->when($sort, function($q, $sort) {
            match($sort) {
                'oldest' => $q->oldest(),
                'az'     => $q->orderBy('title'),
                default  => $q->latest(),
            };
        })
        ->paginate(12)
        ->withQueryString(); // مهم عشان الـ pagination يحتفظ بالفلاتر

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

        // رفع الصور
        if ($request->hasFile('project_images')) {
            foreach ($request->file('project_images') as $image) {
                $path = $image->store('projects_media', 'public');
                $project->media()->create([
                    'file_path' => $path,
                    'medianame' => $image->getClientOriginalName(),
                ]);
            }
        }

        // ربط التخصصات
        $project->specializations()->attach($request->specializations);

        // ربط المهارات
        if ($request->has('skills')) {
            $project->skills()->attach($request->skills);
        }

        // ربط أعضاء الفريق
        if ($request->has('team_members')) {
            foreach ($request->team_members as $member) {
                $project->team_roles()->attach($member['user_id'], [
                    'role' => $member['role']
                ]);
            }
        }
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {

        $project->load(['skills', 'specializations', 'team_roles', 'media','watchers']);
        return view('Project.my_project_details', compact('project'));
    }
        public function showProjectDetails(Project $project)    
    {
     if($project->user_id != auth::user()->id){
        abort(403);
     }
     else{
        $project->load(['skills', 'specializations', 'team_roles', 'media','watchers']);
        return view('Project.my_project_details', compact('project'));
     }
    }
    //   public function showProjectDetails(Project $project)
    // {
    //     $project->load(['skills', 'specializations', 'team_roles', 'media']);
    //     return view('Project.show', compact('project'));
    // }
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

        // تحديث الصور
        if ($request->hasFile('project_images')) {
            // حذف الصور القديمة
            foreach ($project->media as $media) {
                Storage::disk('public')->delete($media->file_path);
                $media->delete();
            }
            // رفع الصور الجديدة
            foreach ($request->file('project_images') as $image) {
                $newPath = $image->store('projects_media', 'public');
                $project->media()->create([
                    'file_path' => $newPath,
                    'medianame' => $image->getClientOriginalName(),
                ]);
            }
        }

        // تحديث التخصصات والمهارات
        $project->specializations()->sync($request->specializations);
        $project->skills()->sync($request->skills ?? []);

        // تحديث أعضاء الفريق
        if ($request->has('team_members')) {
            $project->team_roles()->detach();
            foreach ($request->team_members as $member) {
                $project->team_roles()->attach($member['user_id'], [
                    'role' => $member['role']
                ]);
            }
        }

        return redirect()->route('projects.index')->with('success', 'تم تحديث المشروع بنجاح');
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
        return redirect()->back()->with('success', 'تم حذف المشروع بنجاح');
    }

    /**
     * Get skills by specialization (AJAX)
     */
    public function getSkillsBySpecialization(Specialization $specialization)
    {
        $skills = $specialization->skills;
        return response()->json($skills);
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

    public function addMedia(Project $project)
    {
        return view('project.add_media', compact('project'));
    }
}