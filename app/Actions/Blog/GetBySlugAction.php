<?php

namespace App\Actions\Blog;

use App\Enums\StatusEnum;
use App\Http\Resources\BlogResource;
use App\Models\Blog;

class GetBySlugAction
{
    public function execute(string $slug)
    {
        $blog = Blog::with('tags')
            ->where('status', StatusEnum::DONE->value)
            ->whereNotNull('published_at')
            ->where('slug', $slug)
            ->first();

        return new BlogResource($blog);
    }
}
