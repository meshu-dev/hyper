<?php

namespace App\Actions\Blog;

use App\Enums\StatusEnum;
use App\Http\Resources\BlogListResource;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetByTagAction
{
    public function execute(string $tagName)
    {
        $blogs = Blog::from('blogs AS b')
            ->with('tags')
            ->select('b.*')
            ->join('blog_tags AS bt', 'bt.blog_id', '=', 'b.id')
            ->join('tags AS t', 't.id', '=', 'bt.tag_id')
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('status', StatusEnum::DONE->value)
            ->where('t.name', $tagName)
            ->orderByDesc('published_at')
            ->get();

        return BlogListResource::collection($blogs);
    }
}
