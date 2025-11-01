<?php

namespace App\Transformers\Notion;

use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingTwo;

class NotionHeadingTwoTransformer
{
    public function __construct(protected HeadingTwo $block)
    {
    }

    public function transform(): string
    {
        $heading = $this->block->getContent()->getPlainText();
        return "<h2>$heading</h2>";
    }
}
