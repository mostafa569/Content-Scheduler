<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Jobs\PublishPostJob;

class PublishScheduledPosts extends Command
{
    protected $signature = 'posts:publish';
    protected $description = 'Publish scheduled posts that are due';

    public function handle()
    {
        $duePosts = Post::where('status', 'scheduled')->where('scheduled_time', '<=', now())->get();
        foreach ($duePosts as $post) {
            PublishPostJob::dispatch($post);
        }
        $this->info('Due posts queued for publishing.');
    }
}