<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function all($userId, $filters = [])
    {
        $query = Post::where('user_id', $userId);

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['scheduled_date'])) {
            $query->whereDate('scheduled_time', $filters['scheduled_date']);
        }

        return $query->get();
    }

    public function find($id)
    {
        return Post::findOrFail($id);
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function update(Post $post, array $data)
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post)
    {
        $post->delete();
    }

    public function attachPlatforms(Post $post, array $platforms)
    {
        $post->platforms()->sync($platforms);
    }
}