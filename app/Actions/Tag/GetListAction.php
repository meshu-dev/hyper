<?php

namespace App\Actions\Tag;

use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;

class GetListAction
{
    /**
     * @return LengthAwarePaginator<int, Tag>
     */
    public function execute(int $siteId): LengthAwarePaginator
    {
        $itemsPerPage = config('blog.tags_per_page');
        return Tag::withCount('blogs')->where('site_id', $siteId)->paginate($itemsPerPage);
    }
}
