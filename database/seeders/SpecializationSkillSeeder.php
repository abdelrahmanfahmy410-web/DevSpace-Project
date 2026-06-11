<?php

namespace Database\Seeders;

use App\Models\Specialization;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializationSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = Specialization::all();
        $skills = Skill::all();

        if ($specializations->isEmpty() || $skills->isEmpty()) {
            return;
        }

        // Associate each specialization with 3-6 relevant skills
        foreach ($specializations as $specialization) {
            $skillIds = $skills->random(min(6, $skills->count()))->pluck('id');
            
            foreach ($skillIds as $skillId) {
                DB::table('specialization_skills')->updateOrInsert(
                    [
                        'specialization_id' => $specialization->id,
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
