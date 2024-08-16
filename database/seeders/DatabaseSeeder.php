<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([UserSeeder::class, ProjectSeeder::class]);

        $users = User::all();
        $projects = Project::all();

        $users->each(function ($user) use ($projects) {
            Task::factory()->create([
                'user_id' => $user->id,
                'project_id' => $projects->random()->id,
            ]);
        });

    }
}
