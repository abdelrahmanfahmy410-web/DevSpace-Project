<?php

namespace Database\Factories;

use App\Models\Area_of_interest;
use App\Models\User;
use App\Models\Specialization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Area_of_interest>
 */
class Area_of_interestFactory extends Factory
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
            'specializations_id' => Specialization::factory(),
        ];
    }
}
