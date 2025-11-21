<?php

use App\Transformers\Notion\NotionVideoTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Video;

describe('Transformers - Video', function () {
    it('transforms a Video block to HTML', function () {
        // Arrange
        $value = getTestData('video');
        $videoBlock = Video::create($value);
        $videoBlock->setContent($value);

        // Act
        $result = resolve(
            NotionVideoTransformer::class,
            ['block' => $videoBlock]
        )->transform();

        // Assert
        expect($result)->toBe("<video controls><source src='$value' type='video/mp4' /></video>");
    });
});
