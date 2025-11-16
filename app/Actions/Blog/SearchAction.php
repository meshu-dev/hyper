<?php

namespace App\Actions\Blog;

use App\Enums\BlogStatusEnum;
use App\Models\Blog;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchAction
{
    public function execute(int $siteId, string $searchTerm): LengthAwarePaginator
    {
        $itemsPerPage = config('blog.items_per_page');

        return Blog::where('site_id', $siteId)
            ->where('status', BlogStatusEnum::DONE->value)
            ->whereDate('published_at', '<=', Carbon::now())
            ->whereLike('title', "%$searchTerm%")
            ->orderByDesc('published_at')
            ->paginate($itemsPerPage);
    }
}
