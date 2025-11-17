<?php

namespace App\Transformers\Notion;

use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Video;

class NotionVideoTransformer implements NotionTransformer
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
