<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class GetByTagAction
{
    public function execute(int $siteId, string $tagName): LengthAwarePaginator
    {
        $itemsPerPage = config('blog.items_per_page');

        return Blog::from('blogs AS b')
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
    }
}
