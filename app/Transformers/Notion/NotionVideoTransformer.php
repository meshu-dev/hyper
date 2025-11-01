<?php

namespace App\Transformers\Notion;

use FiveamCode\LaravelNotionApi\Entities\Blocks\Video;

class NotionVideoTransformer
{
    public function __construct(protected Video $block)
    {
    }

    public function transform(): string
    {
        $videoUrl = $this->block->getContent();
        return "<video controls> <source src='$videoUrl' type='video/mp4' /></video>";
    }
}
