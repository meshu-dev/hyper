<?php

namespace App\Actions\Tag;

use App\Models\Tag;

class GetListAction
{
    /**
     * @return LengthAwarePaginator<int, Tag>
     */
    public function execute(int $siteId)
    {
        $itemsPerPage = config('blog.tags_per_page');
        $rows = Tag::withCount('blogs')->where('site_id', $siteId)->get();

        return $rows->map(function ($item) use ($itemsPerPage) {
            if ($item->blogs_count <= $itemsPerPage) {
                $item->total_pages = 1;
            } else {
                $item->total_pages = ceil($item->blogs_count / $itemsPerPage);
            }

            return $item;
        });
    }
}
