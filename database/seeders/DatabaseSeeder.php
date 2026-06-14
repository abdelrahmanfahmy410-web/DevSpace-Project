<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create additional users
        User::factory(20)->create();

        // Seed all models in correct dependency order
        $this->call([
            // Core lookup tables
            RoleSeeder::class,
            SpecializationSeeder::class,
            SkillSeeder::class,

            // Specialization relationships
            SpecializationSkillSeeder::class,

            // User relationships
            UserRoleSeeder::class,

            // Developer and related
            DeveloperSeeder::class,
            DeveloperSkillSeeder::class,
            DeveloperSpecializationSeeder::class,

            // Mentor and related
            MentorSeeder::class,
            MentorSkillSeeder::class,

            // Investor
            InvestorSeeder::class,

            // Area of interests
            Area_of_interestSeeder::class,

            // Projects and related
            ProjectSeeder::class,
            ProjectMediaSeeder::class,
            ProjectSkillSeeder::class,
            ProjectSpecializationSeeder::class,
            ProjectWatchlistSeeder::class,

            // User interactions
            MessageSeeder::class,
            FollowingSeeder::class,
            TeamRoleSeeder::class,
        ]);
    }
}
