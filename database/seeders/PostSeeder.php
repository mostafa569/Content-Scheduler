<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        Post::create([
            'title' => 'Happy New Year',
            'content' => 'Happy New Year',
            'scheduled_time' => now()->addDay(),
            'status' => 'scheduled',
            'user_id' => $user->id,
        ]);

        $post = Post::first();
        $post->platforms()->attach([1, 2]);
    }
}