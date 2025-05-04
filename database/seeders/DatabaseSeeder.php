<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\GuestBook;
use App\Models\Interest;
use App\Models\Photo;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->withPersonalTeam()->create();

        Photo::factory(30)->create();
        Interest::factory(100)->create();

        User::factory()->withPersonalTeam()->create([
            'name' => 'admin',
            'email' => 'admin@amin.com',
            'password' => Hash::make('password'),
            'role' => 1,
        ]);

        User::factory()->withPersonalTeam()->create([
            'name' => 'user',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'role' => 0,
        ]);

        Comment::factory(30)->create();
        Post::factory(30)->create();
        PostComment::factory(300)->create();
        GuestBook::factory()->count(20)->create();
    }
}
