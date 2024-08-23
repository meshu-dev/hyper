<?php

namespace App\Actions\Tag;

use App\Http\Resources\TagListResource;
use App\Models\Tag;

class GetListAction
{
    public function execute(int $siteId)
    {
        $itemsPerPage = config("sites.$siteId.items_per_page");
        $rows = Tag::withCount('blogs')->where('site_id', $siteId)->get();

        $rows = $rows->map(function ($item) use ($itemsPerPage) {
            if ($item->blogs_count <= $itemsPerPage) {
                $item->total_pages = 1;
            } else {
                $item->total_pages = ceil($item->blogs_count / $itemsPerPage);
            }
            return $item;
        });

        return TagListResource::collection($rows);
    }
}
