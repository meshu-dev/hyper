<?php

namespace App\Repositories;

use App\Models\WpBlog;

class WpBlogRepository
{
    public function getByWpPostId(int $wpPostId): WpBlog|null
    {
        return WpBlog::where('wp_post_id', $wpPostId)->first();
    }
}
