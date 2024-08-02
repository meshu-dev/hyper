<?php

namespace App\Actions\Blog;

use App\Enums\StatusEnum;
use App\Http\Resources\BlogListResource;
use App\Models\Blog;

class GetPublishedByTagAction
{
    public function execute(string $tagName)
    {
        $blogs = Blog::from('blogs AS b')
            ->with('tags')
            ->select('b.*')
            ->join('blog_tags AS bt', 'bt.blog_id', '=', 'b.id')
            ->join('tags AS t', 't.id', '=', 'bt.tag_id')
            ->where('status', StatusEnum::DONE->value)
            ->whereNotNull('published_at')
            ->where('t.name', $tagName)
            ->get();

        return BlogListResource::collection($blogs);
    }
}
