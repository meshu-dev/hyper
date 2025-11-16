<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Models\Blog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class GetLatestAction
{
    /**
     * @return Collection<int, Blog>
     */
    public function execute(int $siteId): Collection
    {
        $latestTotal = config('blog.latest_total');

        return Blog::where('site_id', $siteId)
            ->where('status', BlogStatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at')
            ->limit($latestTotal)
            ->get();
    }
}
