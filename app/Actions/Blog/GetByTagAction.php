<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Http\Resources\BlogListResource;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetByTagAction
{
    public function execute(int $siteId, string $tagName)
    {
        $itemsPerPage = config('blog.items_per_page');

        $paginator = Blog::from('blogs AS b')
            ->with('tags')
            ->select('b.*')
            ->join('blog_tags AS bt', 'bt.blog_id', '=', 'b.id')
            ->join('tags AS t', 't.id', '=', 'bt.tag_id')
            ->where('b.site_id', $siteId)
            ->where('b.status', BlogStatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('t.name', $tagName)
            ->orderByDesc('published_at')
            ->paginate($itemsPerPage);

        $rows = BlogListResource::collection($paginator->items());

        return [
            'data' => $rows,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'total' => $paginator->total(),
            ],
        ];
    }
}
