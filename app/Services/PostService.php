<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Repositories\PlatformRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PostService
{
    protected $postRepo;
    protected $platformRepo;

    public function __construct(PostRepository $postRepo, PlatformRepository $platformRepo)
    {
        $this->postRepo = $postRepo;
        $this->platformRepo = $platformRepo;
    }

    public function createPost(array $data)
    {
        $user = Auth::user();
        
       $scheduledDate = Carbon::parse($data['scheduled_time'])->toDateString();

        $scheduledCount = $this->postRepo->all(
        auth()->id(),
        [
            'status' => 'scheduled',
            'scheduled_date' => $scheduledDate
        ]
        )->count();

        if ($scheduledCount >= 10) {
            throw ValidationException::withMessages([
                'rate_limit' => "Max 10 scheduled posts allowed for {$scheduledDate}."
            ]);
        }

        
        $platforms = $data['platforms'] ?? [];
        foreach ($platforms as $platformId) {
            $platform = $this->platformRepo->all()->find($platformId);
            if ($platform->type === 'X' && strlen($data['content']) > 280) {
                throw ValidationException::withMessages(['content' => 'X posts must be under 280 chars.']);
            }
            else if ($platform->type === 'INSTAGRAM' && strlen($data['content']) > 280) {
                throw ValidationException::withMessages(['content' => 'Instagram posts must be under 280 chars.']);
            }
            else if ($platform->type === 'LINKEDIN' && strlen($data['content']) > 280) {
                throw ValidationException::withMessages(['content' => 'LinkedIn posts must be under 280 chars.']);
            }
            else if ($platform->type === 'FACEBOOK' && strlen($data['content']) > 280) {
                throw ValidationException::withMessages(['content' => 'Facebook posts must be under 280 chars.']);
            }
        }

        $data['user_id'] = $user->id;
        $post = $this->postRepo->create($data);
        $this->postRepo->attachPlatforms($post, $platforms);
        
        return $post;
    }

    public function getPosts(array $filters = [])
    {
        return $this->postRepo->all(Auth::user()->id, $filters);
    }

    public function updatePost($id, array $data)
    {
        $post = $this->postRepo->find($id);
        if ($post->user_id !== Auth::user()->id) {
            abort(403);
        }
        return $this->postRepo->update($post, $data);
    }

    public function deletePost($id)
    {
        $post = $this->postRepo->find($id);
        if ($post->user_id !== Auth::user()->id) {
            abort(403);
        }
        $this->postRepo->delete($post);
    }
}