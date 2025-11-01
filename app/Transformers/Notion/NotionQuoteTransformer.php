<?php

namespace App\Transformers\Notion;

use FiveamCode\LaravelNotionApi\Entities\Blocks\Block;

class NotionQuoteTransformer
{
    public function __construct(protected Block $block)
    {
    }

    public function transform(): string
    {
        $quote = $this->block->getContent()->getPlainText();
        return "<blockquote>$quote</blockquote>";
    }
}
