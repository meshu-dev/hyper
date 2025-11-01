<?php

namespace App\Actions\Blog;

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetAction
{
    public function execute(): void
    {
        if (!App::environment('production')) {
            DB::table('blog_tags')->truncate();

            Blog::truncate();
            Tag::truncate();
        }
    }
}
