<?php

namespace App\Actions\WpPost;

use App\Enums\SiteEnum;
use App\Models\WpPost;

class GetTotalPagesAction
{
    public function execute()
    {
        $itemsPerPage = config('sites.' . SiteEnum::DEV_PUSH->value . '.items_per_page');

        $totalBlogs = WpPost::orderByDesc('published_at')->count();

        return ceil($totalBlogs / $itemsPerPage);
    }
}
