<?php

namespace App\Actions\Blog;

use App\Enums\StatusEnum;
use App\Http\Resources\BlogListResource;
use App\Models\Blog;
use Illuminate\Support\Carbon;

class GetListAction
{
    public function execute()
    {
        $blogs = Blog::with('tags')
            ->whereDate('published_at', '<=', Carbon::now())
            ->where('status', StatusEnum::DONE->value)
            ->orderByDesc('published_at')
            ->get();

        return BlogListResource::collection($blogs);
    }
}
