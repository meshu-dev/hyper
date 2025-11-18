<?php

use App\Transformers\Notion\NotionHeadingTwoTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingTwo;

describe('Transformers - H2', function () {
    it('transforms a h2 block to HTML', function () {
        // Arrange
        $value = 'Chicken';
        $h2Block = HeadingTwo::create($value);
        $h2Block->setContent($value);

        // Act
        $result = resolve(
            NotionHeadingTwoTransformer::class,
            ['block' => $h2Block]
        )->transform();

        // Assert
        expect($result)->toBe("<h2>$value</h2>");
    });
});
