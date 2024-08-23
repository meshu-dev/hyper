<?php

namespace App\Actions\Blog;

use App\Actions\WpPost\GetListAction as GetWpListAction;
use App\Enums\{SiteEnum, StatusEnum};
use App\Http\Resources\BlogListResource;
use App\Models\Blog;
use App\Services\ResponseService;
use Illuminate\Support\Carbon;

class GetListAction
{
    public function __construct(protected ResponseService $responseService)
    {
    }

    public function execute(int $siteId)
    {
        // Get DevPush blogs
        if ($siteId === SiteEnum::DEV_PUSH->value) {
            return resolve(GetWpListAction::class)->execute();
        }

        // Get DevNudge blogs
        $itemsPerPage = config("sites.$siteId.items_per_page");

        $paginator = Blog::with('tags')
            ->where('site_id', $siteId)
            ->where('status', StatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at')
            ->paginate($itemsPerPage);

        $rows = BlogListResource::collection($paginator->items());

        return $this->responseService->getPaginationResponse($rows, $paginator);
    }
}
