<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Exceptions\BlogNotFoundException;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetBySlugAction
{
    public function execute(int $siteId, string $slug): Blog
    {
        $blog = Blog::where('site_id', $siteId)
            ->where('status', BlogStatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('slug', $slug)
            ->first();

        throw_unless($blog, BlogNotFoundException::class, 'Blog matching slug could not be found');

        return $blog;
    }
}
