<?php

use App\Actions\Notion\Api\NotionApiGetAction;
use App\Actions\Notion\Block\NotionGetPageBlocksAction;
use App\Collections\{
    BulletItemCollection,
    NumberedItemCollection,
};
use FiveamCode\LaravelNotionApi\Entities\Blocks\{
    BulletedListItem,
    HeadingOne,
    NumberedListItem,
    Paragraph,
};
use FiveamCode\LaravelNotionApi\Entities\Page;
use Illuminate\Support\Collection;
use Mockery\MockInterface;

describe('Actions - NotionGetPageBlocksAction', function () {
    it('gets the page content as HTML', function () {
        // Arrange
        $page = resolve(
            Page::class,
            [
                'responseData' => [
                    'object' => 'page',
                    'id' => Str::uuid(),
                ],
            ],
        );

        // Assert
        $apiGetAction = mock(NotionApiGetAction::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn(new Collection([
                    HeadingOne::create(getTestData('h1')),
                    Paragraph::create(getTestData('p')),
                    BulletedListItem::create('Bullet Point 1'),
                    BulletedListItem::create('Bullet Point 2'),
                    NumberedListItem::create('Numbered Item 1'),
                    NumberedListItem::create('Numbered Item 2'),
                ]));
        });

        // Act
        $result = resolve(NotionGetPageBlocksAction::class, ['notionApiGetAction' => $apiGetAction])->execute($page);

        // Assert
        expect($result)
            ->toBeArray()
            ->and($result[0])
            ->toBeInstanceOf(HeadingOne::class)
            ->and($result[1])
            ->toBeInstanceOf(Paragraph::class)
            ->and($result[2])
            ->toBeInstanceOf(BulletItemCollection::class)
            ->and($result[3])
            ->toBeInstanceOf(NumberedItemCollection::class);
    });
});
