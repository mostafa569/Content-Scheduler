<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use App\Models\PostPlatform;

class PublishPostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function handle()
    {
        foreach ($this->post->platforms as $platform) {
            $success = true;   
            PostPlatform::where('post_id', $this->post->id)->where('platform_id', $platform->id)->update(['platform_status' => $success ? 'published' : 'failed']);
        }

        $this->post->update(['status' => 'published']);
    }
}