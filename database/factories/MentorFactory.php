<?php

namespace Database\Factories;

use App\Models\Mentor;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mentor>
 */
class MentorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'specialization_id' => Specialization::factory(),
            'organization' => fake()->company(),
            'experience_years' => fake()->numberBetween(1, 30),
        ];
    }
}
