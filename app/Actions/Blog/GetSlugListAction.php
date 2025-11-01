<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetSlugListAction
{
    public function execute(int $siteId)
    {
        $blogs = Blog::where('site_id', $siteId)
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('status', BlogStatusEnum::DONE->value)
            ->orderByDesc('published_at')
            ->get();

        return $blogs->pluck('slug');
    }
}
