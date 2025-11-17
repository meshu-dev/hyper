<?php

namespace App\Transformers\Notion;

use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Paragraph;

class NotionParagraphTransformer implements NotionTransformer
{
    public function __construct(protected Paragraph $block)
    {
    }

    public function transform(): string
    {
        $paragraph = $this->block->getContent()->getPlainText();

        return "<p>$paragraph</p>";
    }
}
