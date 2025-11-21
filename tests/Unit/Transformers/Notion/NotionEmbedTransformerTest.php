<?php

use App\Transformers\Notion\NotionEmbedTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Embed;

describe('Transformers - Embed', function () {
    it('transforms an Embed block to HTML', function () {
        // Arrange
        $value = getTestData('embed');
        $embedBlock = Embed::create($value);
        $embedBlock->setContent($value);

        // Act
        $result = resolve(
            NotionEmbedTransformer::class,
            ['block' => $embedBlock]
        )->transform();

        // Assert
        expect($result)->toBe("<embed src='$value' />");
    });
});
