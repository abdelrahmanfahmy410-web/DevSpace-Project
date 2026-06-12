<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeveloperSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developers = Developer::all();
        $skills = Skill::all();

        if ($developers->isEmpty() || $skills->isEmpty()) {
            return;
        }

        // Assign 3-8 skills to each developer
        foreach ($developers as $developer) {
            $skillIds = $skills->random(min(8, $skills->count()))->pluck('id')->unique();
            
            foreach ($skillIds as $skillId) {
                DB::table('developer_skill')->updateOrInsert(
                    [
                        'developer_id' => $developer->id,
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
