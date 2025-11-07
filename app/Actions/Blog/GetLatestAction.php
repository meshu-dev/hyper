<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Http\Resources\BlogListResource;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetLatestAction
{
    public function execute(int $siteId)
    {
        $latestTotal = config('blog.latest_total');

        $rows = Blog::where('site_id', $siteId)
            ->where('status', BlogStatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at')
            ->limit($latestTotal)
            ->get();

        return BlogListResource::collection($rows);
    }
}
