<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Specification;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // User::factory()->user()->create();

        // User::factory()->admin()->create();

        // $users = User::factory()->count(20)->create();

        // Post::factory()->count(10)->create();

        // Category::factory()->count(10)->create();

        // Specification::factory(10)->create();

        // Tag::factory()->count(10)->create();

        \App\Models\Place::factory(10)->create();






    }
}
