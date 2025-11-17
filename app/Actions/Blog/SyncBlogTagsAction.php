<?php

namespace App\Actions\Blog;

use App\Models\{
    Blog,
    Tag
};
use Illuminate\Support\Collection;

class SyncBlogTagsAction
{
    /**
     * @param Collection<int, Tag> $tags
     */
    public function execute(Blog $blog, Collection $tags): void
    {
        $tagIds = $tags->pluck('id');
        $blog->tags()->sync($tagIds);
    }
}
