<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Models\Blog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class GetSlugListAction
{
    /**
     * @return Collection<int, string>
     */
    public function execute(int $siteId): Collection
    {
        $blogs = Blog::where('site_id', $siteId)
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('status', BlogStatusEnum::DONE->value)
            ->orderByDesc('published_at')
            ->get();

        return $blogs->pluck('slug');
    }
}
