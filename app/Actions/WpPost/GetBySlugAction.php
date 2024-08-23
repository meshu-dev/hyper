<?php

namespace App\Actions\WpPost;

use App\Exceptions\BlogNotFoundException;
use App\Http\Resources\BlogResource;
use App\Models\WpPost;

class GetBySlugAction
{
    public function execute(string $slug)
    {
        $blog = WpPost::where('slug', $slug)->first();

        throw_unless($blog, BlogNotFoundException::class, 'Blog matching slug could not be found');

        return new BlogResource($blog);
    }
}
