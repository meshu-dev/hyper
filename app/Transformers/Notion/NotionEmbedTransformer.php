<?php

namespace App\Transformers\Notion;

use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Embed;

class NotionEmbedTransformer implements NotionTransformer
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
