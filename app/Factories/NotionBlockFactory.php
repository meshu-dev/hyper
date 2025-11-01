<?php

namespace App\Factories;

use App\Collections\{
    BulletItemCollection,
    NumberedItemCollection,
};
use App\Transformers\Notion\{
    NotionHeadingOneTransformer,
    NotionHeadingTwoTransformer,
    NotionHeadingThreeTransformer,
    NotionParagraphTransformer,
    NotionImageTransformer,
    NotionBlockTransformer,
    NotionBulletPointListTransformer,
    NotionNumberedListTransformer,
    NotionCodeTransformer,
    NotionEmbedTransformer,
    NotionQuoteTransformer,
    NotionVideoTransformer,
};
use FiveamCode\LaravelNotionApi\Entities\Blocks\{
    Block,
    Embed,
    HeadingOne,
    HeadingTwo,
    HeadingThree,
    Paragraph,
    Image,
    Video,
};

class NotionBlockFactory
{
    public function make(mixed $block)
    {
        return match (true) {
            $block instanceof BulletItemCollection                   => resolve(NotionBulletPointListTransformer::class, ['collection' => $block]),
            $block instanceof NumberedItemCollection                 => resolve(NotionNumberedListTransformer::class, ['collection' => $block]),
            $block instanceof HeadingOne                             => resolve(NotionHeadingOneTransformer::class, ['block' => $block]),
            $block instanceof HeadingTwo                             => resolve(NotionHeadingTwoTransformer::class, ['block' => $block]),
            $block instanceof HeadingThree                           => resolve(NotionHeadingThreeTransformer::class, ['block' => $block]),
            $block instanceof Paragraph                              => resolve(NotionParagraphTransformer::class, ['block' => $block]),
            $block instanceof Image                                  => resolve(NotionImageTransformer::class, ['block' => $block]),
            $block instanceof Video                                  => resolve(NotionVideoTransformer::class, ['block' => $block]),
            $block instanceof Embed                                  => resolve(NotionEmbedTransformer::class, ['block' => $block]),
            $block instanceof Block && $block->getType() === 'code'  => resolve(NotionCodeTransformer::class, ['block' => $block]),
            $block instanceof Block && $block->getType() === 'quote' => resolve(NotionQuoteTransformer::class, ['block' => $block]),
            default                                                  => resolve(NotionBlockTransformer::class, ['block' => $block]),
        };
    }
}
