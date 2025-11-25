<?php

use App\Actions\Notion\Api\NotionApiGetPagesAction;
use App\Actions\Notion\Import\{
    NotionImportDatabaseAction,
    NotionImportPageAction,
    NotionImportPageTagsAction,
};
use App\Enums\SiteEnum;
use FiveamCode\LaravelNotionApi\Entities\Page;
use Mockery\MockInterface;

describe('Actions - NotionImportDatabaseAction', function () {
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

        $pages = collect([$page]);

        $databaseId = 12345;
        $siteId = SiteEnum::DEVNUDGE->value;

        // Assert
        $notionApiGetPagesAction = mock(NotionApiGetPagesAction::class, function (MockInterface $mock) use ($databaseId, $pages) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($databaseId)
                ->andReturn($pages);
        });

        $notionImportPageAction = mock(NotionImportPageAction::class, function (MockInterface $mock) use ($page, $siteId) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($page, $siteId);
        });

        $notionImportPageTagsAction = mock(NotionImportPageTagsAction::class, function (MockInterface $mock) use ($page, $siteId) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($page, $siteId);
        });

        // Act
        resolve(
            NotionImportDatabaseAction::class,
            [
                'notionApiGetPagesAction'    => $notionApiGetPagesAction,
                'notionImportPageAction'     => $notionImportPageAction,
                'notionImportPageTagsAction' => $notionImportPageTagsAction,
            ]
        )->execute(
            $databaseId,
            $siteId
        );
    });
});
