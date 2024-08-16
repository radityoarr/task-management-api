<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Radityo Ar Rasyid',
            'email' => 'radityo@gmail.com',
            'password' => Hash::make('1234')
        ]);
        User::factory(10)->create();
    }
}
