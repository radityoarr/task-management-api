<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('2024-01-01', '2024-12-31')->format('Y-m-d');

        $endDate = $this->faker->dateTimeBetween($startDate, Carbon::parse($startDate)->addWeek()->format('Y-m-d'))->format('Y-m-d');

        return [
            'name' => $this->faker->sentence(rand(2, 3), false),
            'description' => $this->faker->text(500),
            'user_id' => User::factory(),
            'project_id' => Project::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
