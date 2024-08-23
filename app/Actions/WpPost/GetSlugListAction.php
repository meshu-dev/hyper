<?php

namespace App\Actions\WpPost;

use App\Models\WpPost;

class GetSlugListAction
{
    public function execute()
    {
        $blogs = WpPost::orderByDesc('published_at')->get();
        return $blogs->pluck('slug');
    }
}
