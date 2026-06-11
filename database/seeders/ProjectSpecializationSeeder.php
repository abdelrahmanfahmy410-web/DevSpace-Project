<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $specializations = Specialization::all();

        if ($projects->isEmpty() || $specializations->isEmpty()) {
            return;
        }

        // Assign 1-3 specializations to each project
        foreach ($projects as $project) {
            $specIds = $specializations->random(min(3, $specializations->count()))->pluck('id')->unique();
            
            foreach ($specIds as $specId) {
                DB::table('project_specializations')->updateOrInsert(
                    [
                        'project_id' => $project->id,
                        'specialization_id' => $specId,
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
