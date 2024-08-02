<?php

namespace App\Actions\Blog;

use App\Enums\StatusEnum;
use App\Http\Resources\BlogListResource;
use App\Models\Blog;

class GetPublishedListAction
{
    public function execute()
    {
        $blogs = Blog::with('tags')
            ->where('status', StatusEnum::DONE->value)
            ->whereNotNull('published_at')
            ->orderByDesc('published_at')
            ->get();

        return BlogListResource::collection($blogs);
    }
}
