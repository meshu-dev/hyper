<?php

namespace App\Actions\Blog;

use App\Actions\WpPost\GetListAction as GetWpListAction;
use App\Enums\{SiteEnum, StatusEnum};
use App\Http\Resources\BlogListResource;
use App\Models\Blog;
use App\Services\ResponseService;
use Illuminate\Support\Carbon;

class GetLatestAction
{
    public function __construct(protected ResponseService $responseService)
    {
    }

    public function execute(int $siteId)
    {
        $latestTotal = config("sites.$siteId.latest_total");

        $rows = Blog::with('tags')
            ->where('site_id', $siteId)
            ->where('status', StatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at')
            ->limit($latestTotal)
            ->get();

        return BlogListResource::collection($rows);
    }
}
