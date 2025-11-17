<?php

namespace App\Transformers\Notion;

use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingTwo;

class NotionHeadingTwoTransformer implements NotionTransformer
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
