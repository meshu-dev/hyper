<?php

namespace App\Transformers\Notion;

use App\Collections\BulletItemCollection;

class NotionBulletPointListTransformer
{
    public function __construct(protected BulletItemCollection $collection)
    {
    }

    public function transform(): string
    {
        $content = '<ul>';

        foreach ($this->collection as $block) {
            $content .= '<li>' . $block->getRawContent()['text'][0]['plain_text'] . '</li>';
        }

        return $content . '</ul>';
    }
}
