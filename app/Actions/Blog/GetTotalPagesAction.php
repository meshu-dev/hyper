<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetTotalPagesAction
{
    public function execute(int $siteId): int
    {
        $itemsPerPage = config('blog.items_per_page');

        $totalBlogs = Blog::where('site_id', $siteId)
            ->where('status', BlogStatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at')
            ->count();

        return (int) ceil($totalBlogs / $itemsPerPage);
    }
}
