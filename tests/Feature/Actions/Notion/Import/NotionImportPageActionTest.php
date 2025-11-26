<?php

use App\Actions\Notion\Block\NotionGetPageAction;
use App\Actions\Notion\Import\NotionImportPageAction;
use App\Enums\SiteEnum;
use FiveamCode\LaravelNotionApi\Entities\Page;
use Mockery\MockInterface;

describe('Actions - NotionImportPageAction', function () {
    it('imports all the pages for a specific website', function () {
        // Arrange
        $pageData = [
            'notion_id' => (string) Str::uuid(),
            'title' => 'How to upgrade to PHP 8.5',
            'slug' => fake()->url(),
            'content' => getTestData('page'),
            'status' => 'Done',
            'published_at' => now()->subWeeks(1),
            'created_at' => now()->subWeeks(2),
            'updated_at' => now()->subWeeks(2),
        ];

        // Assert
        $getPageAction = mock(NotionGetPageAction::class, function (MockInterface $mock) use ($pageData) {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn($pageData);
        });

        $siteId = SiteEnum::DEVNUDGE->value;

        $page = resolve(
            Page::class,
            [
                'responseData' => [
                    'object' => 'page',
                    'id' => Str::uuid(),
                ],
            ],
        );

        // Act
        resolve(NotionImportPageAction::class, ['getPageAction' => $getPageAction])->execute($page, $siteId);
    });
});
