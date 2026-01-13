<?php

namespace App\Actions\YouTube;

use App\Models\Blog;
use App\Models\Video;
use FiveamCode\LaravelNotionApi\Entities\Page;

class LinkBlogToVideoAction
{
    public function execute(Page $page, Blog $blog): void
    {
        $youTubeId = $page->getProperty('YouTube ID')?->getContent()->getPlainText();

        if ($youTubeId) {
            $video = Video::where('youtube_id', $youTubeId)->first();

            if ($video && !$video->blog) {
                $video->blog()->attach($blog);
            }
        };
    }
}
