<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => Hash::make('321'),
        ]);

        User::factory()->create([
            'username' => 'Mike Rose',
            'email' => 'mike@gmail.com',
            'password' => Hash::make('321'),
            'role' => 'admin',
            'profile_picture' => 'profile_pictures/male1.jpg',
        ]);

        User::factory()->create([
            'username' => 'Adam Sonata',
            'email' => 'adam@gmail.com',
            'password' => Hash::make('321'),
            'profile_picture' => 'profile_pictures/male2.jpg',
        ]);

        User::factory()->create([
            'username' => 'Violet Evergarden',
            'email' => 'violet@gmail.com',
            'password' => Hash::make('321'),
            'profile_picture' => 'profile_pictures/female1.jpg',
        ]);

        User::factory()->create([
            'username' => 'Chloe Tan',
            'email' => 'chloe@gmail.com',
            'password' => Hash::make('321'),
            'profile_picture' => 'profile_pictures/female2.jpg',
        ]);

        // User::factory(3)->create();

        Post::factory(20)->create();

        Comment::factory(100)->create();
    }
}
