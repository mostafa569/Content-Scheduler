<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'date']);
        return $this->postService->getPosts($filters);
    }

    public function store(PostStoreRequest $request)
    {
        return $this->postService->createPost($request->validated());
    }

    public function update(PostUpdateRequest $request, $id)
    {
        return $this->postService->updatePost($id, $request->validated());
    }

    public function destroy($id)
    {
        $this->postService->deletePost($id);
        return response()->json(['message' => 'Post deleted']);
    }

    public function analytics()
    {
        $user = Auth::user();
        $posts = $this->postService->getPosts()->load('platforms');
        
        $perPlatform = [];
        $platformCounts = $posts->flatMap(function ($post) {
            return $post->platforms->pluck('name');
        })->countBy();
        
        $perPlatform = $platformCounts->all();
        
        $totalPosts = $posts->count();
        $successRate = $totalPosts > 0 
            ? ($posts->where('status', 'published')->count() / $totalPosts) * 100 
            : 0;
        
        $scheduledVsPublished = [
            'scheduled' => $posts->where('status', 'scheduled')->count(), 
            'published' => $posts->where('status', 'published')->count()
        ];

        return response()->json([
            'posts_per_platform' => $perPlatform,
            'success_rate' => round($successRate, 2),
            'scheduled_vs_published' => $scheduledVsPublished,
            'total_posts' => $totalPosts
        ]);
    }
    
}