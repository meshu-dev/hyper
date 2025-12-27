<?php

namespace App\Actions\Tag;

use App\Models\Tag;
use Illuminate\Support\Collection;

class GetListAction
{
    /**
     * @return Collection
     */
    public function execute(int $siteId): Collection
    {
        $itemsPerPage = config('blog.tags_per_page');
        $tags = Tag::withCount('blogs')->where('site_id', $siteId)->get();

        $tags->each(function (Tag $item, int $key) use ($itemsPerPage) {
            $item->total_pages = ceil($item->blogs_count / $itemsPerPage);
        });

        return $tags;
    }
}
