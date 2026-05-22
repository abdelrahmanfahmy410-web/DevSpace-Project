<?php

namespace App\Http\Controllers;

use App\Models\Area_of_interest;
use Illuminate\Http\Request;
use App\Models\Specialization;

class AreaOfInterestController extends Controller
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
        //
        $specializations = Specialization::all();
        return view('add_area_of_interest',compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'areas_of_interest' => 'required|array|min:3',
            'areas_of_interest.*' => 'exists:specializations,id',
        ]);

        auth()->user()->areasOfInterest()->sync(
            $request->areas_of_interest
        );

        return redirect()
            ->back()
            ->with(
                'success',
                'Areas of interest saved successfully.'
            );
    }
    /**
     * Display the specified resource.
     */
    public function show(Area_of_interest $area_of_interest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area_of_interest $area_of_interest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area_of_interest $area_of_interest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area_of_interest $area_of_interest)
    {
        //
    }
}
