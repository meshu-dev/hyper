<?php

namespace App\Repositories;

use App\Models\Blog;

class BlogRepository
{
    public function getByNotionPageId(string $pageId): Blog|null
    {
        return Blog::where('notion_page_id', $pageId)->first();
    }
}
