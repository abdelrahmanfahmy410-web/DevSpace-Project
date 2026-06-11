<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        $skills = Skill::all();

        if ($projects->isEmpty() || $skills->isEmpty()) {
            return;
        }

        // Assign 2-6 skills to each project
        foreach ($projects as $project) {
            $skillIds = $skills->random(min(6, $skills->count()))->pluck('id')->unique();
            
            foreach ($skillIds as $skillId) {
                DB::table('project_skills')->updateOrInsert(
                    [
                        'project_id' => $project->id,
                        'skill_id' => $skillId,
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
