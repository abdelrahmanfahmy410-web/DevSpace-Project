<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $skills = Skill::paginate(6);
        return view('admin.skill.skill', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $skills = Skill::all();
     return view('admin.skill.add_skill', compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'skills' => 'array',
            'skills.*' => 'exists:skills,id',
        ]);
        Skill::create([
            'name' => $request->name,
        ]);
        return redirect('/admin/skill')->with('success', 'Skill added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
