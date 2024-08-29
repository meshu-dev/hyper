<?php

namespace App\Actions\Blog;

use App\Actions\WpPost\GetBySlugAction as GetWpBySlugAction;
use App\Enums\{SiteEnum, StatusEnum};
use App\Exceptions\BlogNotFoundException;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetBySlugAction
{
    public function execute(int $siteId, string $slug)
    {
        $blog = Blog::with('tags')
            ->where('site_id', $siteId)
            ->where('status', StatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('slug', $slug)
            ->first();

        throw_unless($blog, BlogNotFoundException::class, 'Blog matching slug could not be found');

        return new BlogResource($blog);
    }
}
