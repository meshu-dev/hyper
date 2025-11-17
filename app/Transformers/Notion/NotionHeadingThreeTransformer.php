<?php

namespace App\Transformers\Notion;

use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingThree;

class NotionHeadingThreeTransformer implements NotionTransformer
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
