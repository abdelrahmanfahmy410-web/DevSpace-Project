<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $skills = ['PHP', 'JavaScript', 'Python', 'Java', 'C#', 'Ruby', 'Go', 'Rust', 
                   'React', 'Vue', 'Angular', 'Node.js', 'Laravel', 'Django', 'SQL', 
                   'MongoDB', 'Docker', 'Kubernetes', 'AWS', 'Azure'];
        
        return [
            'name' => fake()->unique()->randomElement($skills),
        ];
    }
}
