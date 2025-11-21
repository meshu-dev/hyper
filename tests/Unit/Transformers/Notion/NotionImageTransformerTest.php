<?php

use App\Transformers\Notion\NotionImageTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Image;

describe('Transformers - Image', function () {
    it('transforms an Image block to HTML', function () {
        // Arrange
        $value = getTestData('img');
        $imageBlock = Image::create($value);
        $imageBlock->setContent($value);

        // Act
        $result = resolve(
            NotionImageTransformer::class,
            ['block' => $imageBlock]
        )->transform();

        // Assert
        expect($result)->toBe("<img src='$value' />");
    });
});
