<?php

namespace Database\Seeders;

use App\Models\Mentor;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MentorSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mentors = Mentor::all();
        $skills = Skill::all();

        if ($mentors->isEmpty() || $skills->isEmpty()) {
            return;
        }

        // Assign 4-10 skills to each mentor (mentors are experts)
        foreach ($mentors as $mentor) {
            $skillCount = min(10, $skills->count());
            $skillIds = $skills->random(random_int(4, $skillCount))->pluck('id')->unique();
            
            foreach ($skillIds as $skillId) {
                DB::table('mentors_skills')->updateOrInsert(
                    [
                        'mentor_id' => $mentor->id,
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
