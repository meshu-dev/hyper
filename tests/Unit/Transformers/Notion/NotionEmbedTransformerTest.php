<?php

use App\Transformers\Notion\NotionEmbedTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Embed;

describe('Transformers - Embed', function () {
    it('transforms an Embed block to HTML', function () {
        // Arrange
        $value = 'https://twitter.com/aarondfrancis/status/1978872519651102731';
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
