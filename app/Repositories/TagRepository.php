<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    public function getByNotionPageId(string $pageId): Tag|null
    {
        return Tag::where('notion_tag_id', $pageId)->first();
    }

    public function add(array $params): Tag|null
    {
        return Tag::create([
            'notion_tag_id' => $params['id'],
            'name'          => $params['name'],
            'color'         => $params['color']
        ]);
    }
}
