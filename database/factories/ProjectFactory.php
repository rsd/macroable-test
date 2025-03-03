<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['active', 'completed', 'on-hold', 'planning', 'development', 'backlogged'];
        return [
            'team_id' => \App\Models\Team::factory(), // Create a team or use existing
            'name' => fake()->sentence(4), // Shorter sentence for project name
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement($statuses),
            'start_date' => fake()->optional(0.7)->date(), // 70% chance of having a start date
            'end_date' => fake()->optional(0.5)->date(),   // 50% chance of having an end date
        ];
    }
} 