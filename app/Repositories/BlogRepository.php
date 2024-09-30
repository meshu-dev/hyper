<?php

namespace App\Repositories;

use App\Models\Blog;
use App\Models\NotionBlog;
use Illuminate\Database\Query\Builder;

class BlogRepository
{
    public function getByNotionPageId(string $pageId): Blog|null
    {
        return Blog::whereHasMorph(
            'blogable',
            [NotionBlog::class],
            function (Builder $query) use ($pageId) {
                $query->where('notion_page_id', $pageId);
            }
        )->first();
    }
}
