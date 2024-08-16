<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Project::create([
        //     'name' => 'Project A',
        //     'description' =>'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eos cum dignissimos ipsum omnis, sed dolorem, sapiente voluptates consequuntur quidem architecto excepturi perferendis et quod enim tempore ipsa, fuga debitis alias!'

        // ]);
        Project::factory(3)->create();
    }
}
