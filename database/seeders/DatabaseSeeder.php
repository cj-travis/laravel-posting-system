<?php

namespace Database\Seeders;

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
            'username' => 'john',
            'email' => 'john@gmail.com',
            'password' => Hash::make('321'),
        ]);

        User::factory()->create([
            'username' => 'mike',
            'email' => 'mike@gmail.com',
            'password' => Hash::make('321'),
        ]);

        User::factory(3)->create();
  
        // $users = User::all();

        Post::factory(20)->create();
    }
}
