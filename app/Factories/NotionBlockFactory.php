<?php

namespace App\Factories;

use App\Collections\BulletItemCollection;
use App\Collections\NumberedItemCollection;
use App\Transformers\Notion\NotionBlockTransformer;
use App\Transformers\Notion\NotionBulletPointListTransformer;
use App\Transformers\Notion\NotionCodeTransformer;
use App\Transformers\Notion\NotionEmbedTransformer;
use App\Transformers\Notion\NotionHeadingOneTransformer;
use App\Transformers\Notion\NotionHeadingThreeTransformer;
use App\Transformers\Notion\NotionHeadingTwoTransformer;
use App\Transformers\Notion\NotionImageTransformer;
use App\Transformers\Notion\NotionNumberedListTransformer;
use App\Transformers\Notion\NotionParagraphTransformer;
use App\Transformers\Notion\NotionQuoteTransformer;
use App\Transformers\Notion\NotionVideoTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Block;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Embed;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingOne;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingThree;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingTwo;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Image;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Paragraph;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Video;

class NotionBlockFactory
{
    public function make(mixed $block)
    {
        return match (true) {
            $block instanceof BulletItemCollection => resolve(NotionBulletPointListTransformer::class, ['collection' => $block]),
            $block instanceof NumberedItemCollection => resolve(NotionNumberedListTransformer::class, ['collection' => $block]),
            $block instanceof HeadingOne => resolve(NotionHeadingOneTransformer::class, ['block' => $block]),
            $block instanceof HeadingTwo => resolve(NotionHeadingTwoTransformer::class, ['block' => $block]),
            $block instanceof HeadingThree => resolve(NotionHeadingThreeTransformer::class, ['block' => $block]),
            $block instanceof Paragraph => resolve(NotionParagraphTransformer::class, ['block' => $block]),
            $block instanceof Image => resolve(NotionImageTransformer::class, ['block' => $block]),
            $block instanceof Video => resolve(NotionVideoTransformer::class, ['block' => $block]),
            $block instanceof Embed => resolve(NotionEmbedTransformer::class, ['block' => $block]),
            $block instanceof Block && $block->getType() === 'code' => resolve(NotionCodeTransformer::class, ['block' => $block]),
            $block instanceof Block && $block->getType() === 'quote' => resolve(NotionQuoteTransformer::class, ['block' => $block]),
            default => resolve(NotionBlockTransformer::class, ['block' => $block]),
        };
    }
}
