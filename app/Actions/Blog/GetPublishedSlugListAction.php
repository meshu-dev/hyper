<?php

namespace App\Actions\Blog;

use App\Enums\StatusEnum;
use App\Models\Blog;

class GetPublishedSlugListAction
{
    public function execute()
    {
        $blogs = Blog::where('status', StatusEnum::DONE->value)
            ->whereNotNull('published_at')
            ->get();

        return $blogs->pluck('slug');
    }
}
