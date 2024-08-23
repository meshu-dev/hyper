<?php

namespace App\Actions\Blog;

use App\Enums\StatusEnum;
use App\Http\Resources\BlogListResource;
use App\Models\Blog;
use App\Services\ResponseService;
use Illuminate\Support\Carbon;

class GetByTagAction
{
    public function __construct(protected ResponseService $responseService)
    {
    }

    public function execute(int $siteId, string $tagName)
    {
        $itemsPerPage = config("sites.$siteId.items_per_page");

        $paginator = Blog::from('blogs AS b')
            ->with('tags')
            ->select('b.*')
            ->join('blog_tags AS bt', 'bt.blog_id', '=', 'b.id')
            ->join('tags AS t', 't.id', '=', 'bt.tag_id')
            ->where('b.site_id', $siteId)
            ->where('b.status', StatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('t.name', $tagName)
            ->orderByDesc('published_at')
            ->paginate($itemsPerPage);

        $rows = BlogListResource::collection($paginator->items());

        return $this->responseService->getPaginationResponse($rows, $paginator);
    }
}
