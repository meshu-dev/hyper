<?php

use App\Actions\Notion\Api\NotionApiGetPagesAction;
use App\Actions\Notion\Block\NotionGetPageAction;
use App\Actions\Notion\Import\NotionImportPagesAction;
use App\Actions\Notion\Import\NotionImportPageTagsAction;
use App\Enums\SiteEnum;
use App\Models\Tag;
use Illuminate\Support\Collection;
use Mockery\MockInterface;

describe('Actions - NotionImportPagesAction', function () {
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

        $apiGetPagesAction = mock(NotionApiGetPagesAction::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn(new Collection([
                    null
                ]));
        });

        /*
        $page = mock(NotionGetPageAction::class, function (MockInterface $mock) use ($pageData) {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn($pageData);
        }); */

        $databaseId = 12345;
        $siteId = SiteEnum::DEVNUDGE->value;

        // Act
        $result = resolve(NotionImportPagesAction::class)->execute($databaseId, $siteId);

        // Assert
    });
});
