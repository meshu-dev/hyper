<?php

namespace App\Actions\Blog;

use App\Enums\StatusEnum;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetTotalPagesAction
{
    public function execute()
    {
        $itemsPerPage = config('blog.items_per_page');

        $totalBlogs = Blog::whereDate('published_at', '<=', Carbon::now())
            ->where('status', StatusEnum::DONE->value)
            ->orderByDesc('published_at')
            ->count();

        return ceil($totalBlogs / $itemsPerPage);
    }
}
