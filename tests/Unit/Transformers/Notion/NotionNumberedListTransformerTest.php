<?php

use App\Collections\NumberedItemCollection;
use App\Transformers\Notion\NotionNumberedListTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\NumberedListItem;

describe('Transformers - Numbered list', function () {
    it('transforms a Numbered list block collection to HTML', function () {
        // Arrange
        $values = ['Install PHP', 'Install Composer', 'Install Laravel installer', 'Use Laravel installer to create app'];

        $numberedListCollection = resolve(NumberedItemCollection::class);

        foreach ($values as $value) {
            $block = NumberedListItem::create($value);
            $block->setRawContent([
                'text' => [['plain_text' => $value]],
            ]);

            $numberedListCollection->push($block);
        }

        $values = array_map(fn ($value): string => '<li>' . $value . '</li>', $values);

        // Act
        $result = resolve(
            NotionNumberedListTransformer::class,
            ['collection' => $numberedListCollection]
        )->transform();

        // Assert
        expect($result)->toBe("<ol>" . implode('', $values) . "</ol>");
    });
});
