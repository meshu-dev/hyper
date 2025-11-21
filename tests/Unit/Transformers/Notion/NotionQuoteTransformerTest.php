<?php

use App\Transformers\Notion\NotionQuoteTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Quote;

describe('Transformers - Quote', function () {
    it('transforms a Quote block to HTML', function () {
        // Arrange
        $value = getTestData('quote');
        $h2Block = Quote::create($value);
        $h2Block->setContent($value);

        // Act
        $result = resolve(
            NotionQuoteTransformer::class,
            ['block' => $h2Block]
        )->transform();

        // Assert
        expect($result)->toBe("<blockquote>$value</blockquote>");
    });
});
