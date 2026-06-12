<?php

namespace Database\Seeders;

use App\Models\Area_of_interest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Area_of_interestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Area_of_interest::factory(20)->create();
    }
}
