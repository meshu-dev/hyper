<?php

namespace App\Actions\Blog;

use App\Enums\StatusEnum;
use App\Http\Resources\BlogListResource;
use App\Models\Blog;

class SearchAction
{
    public function execute(string $searchTerm)
    {
        $blogs = Blog::with('tags')
            ->where('status', StatusEnum::DONE->value)
            ->whereNotNull('published_at')
            ->whereLike('title', "%$searchTerm%")
            ->get();

        return BlogListResource::collection($blogs);
    }
}
