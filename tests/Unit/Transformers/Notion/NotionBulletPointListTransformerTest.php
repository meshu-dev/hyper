<?php

use App\Collections\BulletItemCollection;
use App\Transformers\Notion\NotionBulletPointListTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\BulletedListItem;

describe('Transformers - Bullet Point list', function () {
    it('transforms a Bullet Point block collection to HTML', function () {
        // Arrange
        $values = ['KFC', 'Burger King', 'Burger Boi', 'Subway'];

        $bulletPointCollection = resolve(BulletItemCollection::class);

        foreach ($values as $value) {
            $block = BulletedListItem::create($value);
            $block->setRawContent([
                'text' => [['plain_text' => $value]],
            ]);

            $bulletPointCollection->push($block);
        }

        $values = array_map(fn ($value): string => '<li>' . $value . '</li>', $values);

        // Act
        $result = resolve(
            NotionBulletPointListTransformer::class,
            ['collection' => $bulletPointCollection]
        )->transform();

        // Assert
        expect($result)->toBe("<ul>" . implode('', $values) . "</ul>");
    });
});
