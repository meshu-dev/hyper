<?php

namespace App\Transformers\Notion;

use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Block;

class NotionQuoteTransformer implements NotionTransformer
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
