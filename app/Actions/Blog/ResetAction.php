<?php

namespace App\Actions\Blog;

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class ResetAction
{
    public function execute(): void
    {
        DB::table('blog_tags')->truncate();

        Blog::truncate();
        Tag::truncate();
    }
}
