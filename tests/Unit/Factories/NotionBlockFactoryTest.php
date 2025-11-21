<?php

use App\Collections\{
    BulletItemCollection,
    NumberedItemCollection,
};
use App\Factories\NotionBlockFactory;
use App\Transformers\Notion\{
    NotionBlockTransformer,
    NotionBulletPointListTransformer,
    NotionCodeTransformer,
    NotionEmbedTransformer,
    NotionHeadingOneTransformer,
    NotionHeadingThreeTransformer,
    NotionHeadingTwoTransformer,
    NotionImageTransformer,
    NotionNumberedListTransformer,
    NotionParagraphTransformer,
    NotionQuoteTransformer,
    NotionVideoTransformer,
};
use FiveamCode\LaravelNotionApi\Entities\Blocks\{
    Block,
    Embed,
    HeadingOne,
    HeadingThree,
    HeadingTwo,
    Paragraph,
    Image,
    ToDo,
    Video,
};

describe('Factories - NotionBlockFactory', function () {
    it('makes the transformer from the block factory', function ($block, $transformer) {
        // Act
        $block = $block instanceof Closure ? $block() : $block;
        $builtTransformer = resolve(NotionBlockFactory::class)->make($block);

        // Assert
        expect($builtTransformer)->toBeInstanceOf($transformer);
    })->with([
        'ul' => [
            resolve(BulletItemCollection::class),
            NotionBulletPointListTransformer::class,
        ],
        'ol' => [
            resolve(NumberedItemCollection::class),
            NotionNumberedListTransformer::class,
        ],
        'h1' => [
            HeadingOne::create(getTestData('h1')),
            NotionHeadingOneTransformer::class,
        ],
        'h2' => [
            HeadingTwo::create(getTestData('h2')),
            NotionHeadingTwoTransformer::class,
        ],
        'h3' => [
            HeadingThree::create(getTestData('h3')),
            NotionHeadingThreeTransformer::class,
        ],
        'p' => [
            Paragraph::create(getTestData('p')),
            NotionParagraphTransformer::class,
        ],
        'img' => [
            Image::create(getTestData('img')),
            NotionImageTransformer::class,
        ],
        'video' => [
            Video::create(getTestData('video')),
            NotionVideoTransformer::class,
        ],
        'embed' => [
            Embed::create(getTestData('embed')),
            NotionEmbedTransformer::class,
        ],
        'code' => [
            function () {
                $block = resolve(Block::class);
                $block->setType('code');

                return $block;
            },
            NotionCodeTransformer::class,
        ],
        'quote' => [
            function () {
                $block = resolve(Block::class);
                $block->setType('quote');

                return $block;
            },
            NotionQuoteTransformer::class,
        ],
        'block' => [
            ToDo::create(getTestData('block')),
            NotionBlockTransformer::class,
        ],
    ]);
});
