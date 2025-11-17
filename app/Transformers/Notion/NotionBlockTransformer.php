<?php

namespace App\Transformers\Notion;

use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Block;

class NotionBlockTransformer implements NotionTransformer
{
    public function __construct(protected Block $block)
    {
    }

    public function transform(): string
    {
        if ($this->block->getType() === 'table_of_contents') {
            return '';
        }
        dd('Block', $this->block, $this->block->getType());
        $value = $this->block->getContent()->getPlainText();

        return "<p>$value</p>";
    }
}
