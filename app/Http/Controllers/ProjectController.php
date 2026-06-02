<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Specialization;
use App\Models\team_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // استدعاء الفايل سيستم للحذف والتخزين

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch projects with their related models dynamically
        $projects = Project::with(['skills', 'specializations', 'media'])->get();
        
        // Returns the view located at resources/views/project/index.blade.php
        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = \App\Models\Specialization::all();
        $skills = [];
        return view('Project.project_add', compact('specializations', 'skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {

        $project->load(['skills', 'specializations', 'team_roles', 'media','watchers']);
        return view('Project.project_details', compact('project'));
    }
        public function showProjectDetails(Project $project)    
    {
     if($project->user_id != auth::user()->id){
        abort(403);
     }
     else{
        $project->load(['skills', 'specializations', 'team_roles', 'media','watchers']);
        return view('Project.project_details', compact('project'));
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|max:100',
            'specializations' => 'required|array', 
            'specializations.*' => 'exists:specializations,id', 
            'skills' => 'nullable|array', 
            'skills.*' => 'exists:skills,id',
            'project_images'   => 'nullable|array',
            'project_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'repository_link' => $request->repository_link,
            'live_demo_link' => $request->live_demo_link,
            'type' => $request->type,
        ]);

        // تحديث الصورة
        if ($request->hasFile('project_images')) {
    // حذف الصور القديمة كلها
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

        // تحديث التخصصات والمهارات باستخدام sync لمنع التكرار
        $project->specializations()->sync($request->specializations);
        $project->skills()->sync($request->skills ?? []);

        return redirect()->route('project.index')->with('success', 'تم تحديث المشروع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // حذف الصورة من السيرفر قبل حذف المشروع
        if ($project->media()->exists()) {
            foreach ($project->media as $media) {
                Storage::disk('public')->delete($media->file_path);
            }
        }
        
        $project->delete();
        return redirect()->back()->with('success', 'تم حذف المشروع بنجاح');
    }

    public function getSkillsBySpecialization(Specialization $specialization)
    {
        $skills = $specialization->skills; 
        return response()->json($skills);
       }

    public function show_projects($id){

        
        $project = Project::with(['skills', 'specializations', 'team_roles'])->findOrFail($id);
        
        return view('projects_show', compact('project'));
        }
        
        public function myProjects()
{
    $projects = Project::where('user_id', auth()->id())
                       ->latest()
                       ->get();

    return view('projects.my-projects', compact('projects'));
}

    public function addMedia(Project $project)
    {
        return view('project.add_media', compact('project'));
    }

}
