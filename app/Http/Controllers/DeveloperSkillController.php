<?php
namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeveloperSkillController extends Controller
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit()
    {
        $skills      = Skill::all();
        $id          = auth()->id();
        $developer   = DB::table('developers')->where('user_id', $id)->first();
        $developerId = $developer->id;

        $developerSkills = DB::table('developer_skill')
            ->where('developer_id', $developerId)
            ->pluck('skill_id')
            ->toArray();

        return view('developer.skills', [
            'skills'          => $skills,
            'developerSkills' => $developerSkills,
            'id'              => $id,
            'update_url'      => url('/developer/skills/' . $id . '/update'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //   dd($request->all());
        $id          = auth()->id();
        $developer   = DB::table('developers')->where('user_id', $id)->first();
        $developerId = $developer->id;

        DB::table('developer_skill')
            ->where('developer_id', $developerId)
            ->delete();

        if ($request->has('skills')) {
            $data = [];
            foreach ($request->skills as $skillId) {
                $data[] = [
                    'developer_id' => $developerId,
                    'skill_id'     => $skillId,
                ];
            }
            DB::table('developer_skill')->insert($data);
        }

        return redirect('/dashboard')
            ->with('success', 'Skills updated successfully!');
    }

}
