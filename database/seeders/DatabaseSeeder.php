<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Toni F',
            'email' => 'toni@toni.es',
            'password' => '123'
        ]);

        User::factory()->create([
            'name' => 'Raquel F',
            'email' => 'raquel@raquel.es',
            'password' => '123'
        ]);

        Task::factory(10)->create();
    
    }
}
