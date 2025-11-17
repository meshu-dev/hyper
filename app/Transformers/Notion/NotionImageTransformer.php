<?php

namespace App\Transformers\Notion;

use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Image;

class NotionImageTransformer implements NotionTransformer
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
