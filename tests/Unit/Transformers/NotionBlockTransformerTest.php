<?php

use App\Transformers\Notion\NotionBlockTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\ToDo;

describe('Transformers - Block', function () {
    it('transforms a Block to HTML', function () {
        // Arrange
        $value = 'Blah Blah';
        $block = ToDo::create($value);
        $block->setContent($value);

        // Act
        $result = resolve(
            NotionBlockTransformer::class,
            ['block' => $block]
        )->transform();

        // Assert
        expect($result)->toBe("<p>$value</p>");
    });
});
