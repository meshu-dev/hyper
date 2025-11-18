<?php

use App\Transformers\Notion\NotionCodeTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Block;

describe('Transformers - Code', function () {
    it('transforms a Code block to HTML', function () {
        // Arrange
        $value = 'php -S localhost:8000';

        $codeBlock = Block::fromResponse([
            'type' => 'code',
            'object' => 'block',
            'id' => '94d5b1e1-b41c-49f1-9600-341070c1f46f',
            'code' => ['language' => 'php'],
        ]);

        $codeBlock->setRawContent([
            'text' => [['plain_text' => $value]],
        ]);

        // Act
        $result = resolve(
            NotionCodeTransformer::class,
            ['block' => $codeBlock]
        )->transform();

        // Assert
        expect($result)->toBe(
            "<pre><code class='language-php'>".
                htmlspecialchars($value).
            '</code></pre>'
        );
    });
});
