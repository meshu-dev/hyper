<?php

use App\Transformers\Notion\NotionHeadingThreeTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\HeadingThree;

describe('Transformers - H3', function () {
    it('transforms a h3 block to HTML', function () {
        // Arrange
        $value = 'Pork';
        $h3Block = HeadingThree::create($value);
        $h3Block->setContent($value);

        // Act
        $result = resolve(
            NotionHeadingThreeTransformer::class,
            ['block' => $h3Block]
        )->transform();

        // Assert
        expect($result)->toBe("<h3>$value</h3>");
    });
});
