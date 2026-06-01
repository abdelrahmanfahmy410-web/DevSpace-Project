<?php

namespace Database\Factories;

use App\Models\TeamRole;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeamRole>
 */
class TeamRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = ['lead', 'developer', 'designer', 'manager', 'contributor', 'reviewer'];
        
        return [
            'role' => fake()->randomElement($roles),
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
        ];
    }
}
