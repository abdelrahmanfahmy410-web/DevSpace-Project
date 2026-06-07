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
            'areas_of_interest' => 'required|array|min:1',
            'areas_of_interest.*' => 'exists:specializations,id',
        ]);
      foreach ($request->areas_of_interest as $areaId) {
            Area_of_interest::create([
                'user_id' => auth()->id(),
                'specializations_id' => $areaId,
            ]);
        }
        return redirect()
            ->back()
            ->with(
                'success',
                'Areas of interest saved successfully.'
            );
    }

}
