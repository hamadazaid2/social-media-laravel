<?php

namespace Database\Seeders;

use App\Models\CategoryLookup;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;
use App\Models\Follower;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Hamada Zaid',
            'email' => 'hamada@dash.ps',
        ]);

        User::factory(30)->create();
        CategoryLookup::factory(10)->create();
        Post::factory(100)->create();
        Comment::factory(1000)->create();
        Reaction::factory(2000)->create();
        Follower::factory(100)->create();
    }
}
