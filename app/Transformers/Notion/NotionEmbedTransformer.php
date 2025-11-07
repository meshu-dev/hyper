<?php

namespace App\Transformers\Notion;

use FiveamCode\LaravelNotionApi\Entities\Blocks\Embed;

class NotionEmbedTransformer
{
    public function __construct(protected Embed $block)
    {
    }

    public function transform(): string
    {
        $url = $this->block->getContent();

        return "<embed src='$url' />";
    }
}
