<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class GetListAction
{
    /**
     * @return LengthAwarePaginator<int, Blog>
     */
    public function execute(int $siteId): LengthAwarePaginator
    {
        $itemsPerPage = config('blog.items_per_page');

        return Blog::with(['tags'])
            ->where('site_id', $siteId)
            ->where('status', BlogStatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderByDesc('published_at')
            ->paginate($itemsPerPage);
    }
}
