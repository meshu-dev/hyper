<?php

namespace App\Actions\Blog;

use App\Actions\WpPost\GetSlugListAction as GetWpSlugListAction;
use App\Enums\{SiteEnum, StatusEnum};
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetSlugListAction
{
    public function execute(int $siteId)
    {
        $blogs = Blog::whereDate('published_at', '<=', Carbon::now())
            ->where('site_id', $siteId)
            ->where('status', StatusEnum::DONE->value)
            ->orderByDesc('published_at')
            ->get();

        return $blogs->pluck('slug');
    }
}
