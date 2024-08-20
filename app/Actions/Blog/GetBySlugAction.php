<?php

namespace App\Actions\Blog;

use App\Enums\StatusEnum;
use App\Exceptions\BlogNotFoundException;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetBySlugAction
{
    public function execute(string $slug)
    {
        $blog = Blog::with('tags')
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('status', StatusEnum::DONE->value)
            ->where('slug', $slug)
            ->first();

        throw_unless($blog, BlogNotFoundException::class, 'Blog matching slug could not be found');

        return new BlogResource($blog);
    }
}
