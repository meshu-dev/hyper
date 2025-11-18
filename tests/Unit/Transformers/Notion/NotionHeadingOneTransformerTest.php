<?php

use App\Transformers\Notion\NotionHeadingOneTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingOne;

describe('Transformers - H1', function () {
    it('transforms a h1 block to HTML', function () {
        // Arrange
        $value = 'Beef';
        $h1Block = HeadingOne::create($value);
        $h1Block->setContent($value);

        // Act
        $result = resolve(
            NotionHeadingOneTransformer::class,
            ['block' => $h1Block]
        )->transform();

        // Assert
        expect($result)->toBe("<h1>$value</h1>");
    });
});
