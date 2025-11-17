<?php

namespace App\Transformers\Notion;

use App\Collections\NumberedItemCollection;
use App\Contracts\NotionTransformer;

class NotionNumberedListTransformer implements NotionTransformer
{
    public function __construct(protected NumberedItemCollection $collection)
    {
    }

    public function transform(): string
    {
        $content = '<ol>';

        foreach ($this->collection as $block) {
            $content .= '<li>'.$block->getRawContent()['text'][0]['plain_text'].'</li>';
        }

        return $content.'</ol>';
    }
}
