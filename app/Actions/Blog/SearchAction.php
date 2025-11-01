<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Http\Resources\BlogListResource;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class SearchAction
{
    public function execute(int $siteId, string $searchTerm)
    {
        $itemsPerPage = config('blog.items_per_page');

        $paginator = Blog::where('site_id', $siteId)
            ->where('status', BlogStatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereLike('title', "%$searchTerm%")
            ->orderByDesc('published_at')
            ->paginate($itemsPerPage);

        $rows = BlogListResource::collection($paginator->items());

        return [
            'data' => $rows,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'total'        => $paginator->total()
            ]
        ];
    }
}
