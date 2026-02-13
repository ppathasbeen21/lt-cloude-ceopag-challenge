<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Developer>
 */
class DeveloperFactory extends Factory
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'seniority' => fake()->randomElement(['Jr', 'Pl', 'Sr']),
            'skills' => fake()->randomElements(['PHP', 'Laravel', 'JavaScript', 'Vue', 'React', 'MySQL', 'Docker', 'Git'], rand(2, 5)),
        ];
    }
}
