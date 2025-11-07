<?php

namespace App\Transformers\Notion;

use FiveamCode\LaravelNotionApi\Entities\Blocks\Image;

class NotionImageTransformer
{
    public function __construct(protected Image $block)
    {
    }

    public function transform(): string
    {
        $imageUrl = $this->block->getContent();

        return "<img src='$imageUrl' />";
    }
}
