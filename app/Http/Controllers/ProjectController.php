<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Specialization;
use Illuminate\Http\Request;

class ProjectController extends Controller
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
        $specializations = \App\Models\Specialization::all();
        $skills = [];
        return view('project.add_project', compact('specializations', 'skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|string|max:255',
         'description' => 'required|string',
         'type' => 'required|string|max:100',
         
         'specializations' => 'required|array', // تعديل: يجب أن تكون مصفوفة
         'specializations.*' => 'exists:specializations,id', // التأكد من صحة كل تخصص
         'skills' => 'nullable|array', // المهارات القادمة من الـ Checkboxes
         'skills.*' => 'exists:skills,id',
     ]);
        $project = Project::create([
         'title' => $request->title,
         'description' => $request->description,
         'repository_link' => $request->repository_link,
         'live_demo_link' => $request->live_demo_link,
         'type' => $request->type,
        ]);

        // ارتباط التخصصات بالمشروع
        $project->specializations()->attach($request->specializations);

        // ارتباط المهارات بالمشروع
        if ($request->has('skills')) {
            $project->skills()->attach($request->skills);
        }

        return redirect("/");
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load(['skills', 'specializations', 'member']);
        return view('Project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
    public function getSkillsBySpecialization(Specialization $specialization)
    {
        $skills = $specialization->skills;
        $specializations = \App\Models\Specialization::all();
        return response()->json($skills);
    }
}
