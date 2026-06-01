<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use Illuminate\Http\Request;
use App\Models\Skill;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specializations = Specialization::all();
    
        return view('specialization.specialization', compact('specializations'));
    }
     //display specialization with skills
        public function specializationSkills( )
        {
            $specializations = Specialization::with('skills')->get();
            return view('specialization.specialization_skills', compact('specializations'));
        }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $skills = Skill::all();
         $specializations = Specialization::all();
        return view('specialization.add_specialization', compact('skills', 'specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:specializations,name',
            'skills' => 'array',
            'skills.*' => 'exists:skills,id',
        ]);
        //get or create specialization

      if ($request->name == 'Other') {
        $request->validate([
            'other_specialization' => 'required|string|max:255',
        ]);
        
        $specialization = Specialization::create([
            'name' => $request->other_specialization,
        ]);
    }
    else {
        $specialization = Specialization::where('name', $request->name)->first();
         if (!$specialization) {
            return back()->withErrors(['name' => 'Specialization not found']);
        }
    }
        $specialization->skills()->sync($request->skills);
    
        return redirect('/')->with('success', 'Specialization created successfully!');
    }
     
    /**
     * Display the specified resource.
     */
    public function show(Specialization $specialization)
    {
      //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialization $specialization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Specialization $specialization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialization $specialization)
    {
        //
    }
}
