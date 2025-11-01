<?php

namespace App\Actions\Blog;

use App\Models\Blog;
use Illuminate\Support\Collection;

class SyncBlogTagsAction
{
    public function execute(Blog $blog, Collection $tags): void
    {
        $tagIds = $tags->pluck('id');
        $blog->tags()->sync($tagIds);
    }
}
