<?php

namespace App\Transformers\Notion;

use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingThree;

class NotionHeadingThreeTransformer
{
    public function __construct(protected HeadingThree $block)
    {
    }

    public function transform(): string
    {
        $heading = $this->block->getContent()->getPlainText();
        return "<h3>$heading</h3>";
    }
}
