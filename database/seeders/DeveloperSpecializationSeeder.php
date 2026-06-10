<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Specialization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeveloperSpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developers = Developer::all();
        $specializations = Specialization::all();

        if ($developers->isEmpty() || $specializations->isEmpty()) {
            return;
        }

        // Assign 1-3 additional specializations to each developer
        foreach ($developers as $developer) {
            // Already has one specialization from developers table
            $additionalSpecs = $specializations->random(min(3, $specializations->count()))->pluck('id')->unique();
            
            foreach ($additionalSpecs as $specId) {
                DB::table('developers_specializations')->updateOrInsert(
                    [
                        'developer_id' => $developer->id,
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
