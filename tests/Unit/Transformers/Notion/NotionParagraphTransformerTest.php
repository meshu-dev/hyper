<?php

use App\Transformers\Notion\NotionParagraphTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Paragraph;

describe('Transformers - Paragraph', function () {
    it('transforms a h2 block to HTML', function () {
        // Arrange
        $value = 'This is the problem they have created for themselves';
        $paragraphBlock = Paragraph::create($value);
        $paragraphBlock->setContent($value);

        // Act
        $result = resolve(
            NotionParagraphTransformer::class,
            ['block' => $paragraphBlock]
        )->transform();

        // Assert
        expect($result)->toBe("<p>$value</p>");
    });
});
