<?php

namespace App\Repositories\Wordpress;

use App\Models\Wordpress\WpPost;

class WpPostRepository
{
    public function getAll()
    {
        return WpPost::where('post_type', 'post')
                     ->whereIn('post_status', ['publish', 'trash'])
                     ->get();
    }
}