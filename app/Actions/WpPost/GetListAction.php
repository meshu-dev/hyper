<?php

namespace App\Actions\WpPost;

use App\Enums\SiteEnum;
use App\Http\Resources\BlogListResource;
use App\Models\WpPost;
use App\Services\ResponseService;

class GetListAction
{
    public function __construct(protected ResponseService $responseService)
    {
    }

    public function execute()
    {
        $itemsPerPage = config('sites.' . SiteEnum::DEV_PUSH->value . '.items_per_page');

        $paginator = WpPost::orderByDesc('published_at')
            ->paginate($itemsPerPage);

        $rows = BlogListResource::collection($paginator->items());

        return $this->responseService->getPaginationResponse($rows, $paginator);
    }
}
