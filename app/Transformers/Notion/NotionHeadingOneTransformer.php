<?php

namespace App\Transformers\Notion;

use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingOne;

class NotionHeadingOneTransformer implements NotionTransformer
{
    public function __construct(protected HeadingOne $block)
    {
    }

    public function transform(): string
    {
        $heading = $this->block->getContent()->getPlainText();

        return "<h1>$heading</h1>";
    }
}
