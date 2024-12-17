<?php

namespace Database\Seeders;

use App\Models\Category;
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

        if (User::where('email', 'toni@toni.es')->count() == 0) {
            User::factory()->create([
                'name' => 'Toni F',
                'email' => 'toni@toni.es',
                'password' => '123'
            ]);
        }
        
        if (User::where('email', 'raquel@raquel.es')->count() == 0) {
            User::factory()->create([
                'name' => 'Raquel F',
                'email' => 'raquel@raquel.es',
                'password' => '123'
            ]);
        }

        

        Task::factory(10)->create();
        Category::factory(3)->create();
    
    }
}
