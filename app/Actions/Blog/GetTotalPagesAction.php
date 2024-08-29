<?php

namespace App\Actions\Blog;

use App\Actions\WpPost\GetTotalPagesAction as GetWpTotalPagesAction;
use App\Enums\{SiteEnum, StatusEnum};
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetTotalPagesAction
{
    public function execute(int $siteId)
    {
        $itemsPerPage = config("sites.$siteId.items_per_page");

        $totalBlogs = Blog::where('site_id', $siteId)
            ->where('status', StatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at')
            ->count();

        return ceil($totalBlogs / $itemsPerPage);
    }
}
