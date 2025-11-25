<?php

use App\Actions\Notion\Block\NotionGetPageAction;
use App\Actions\Notion\Block\NotionGetPageContentAction;
use FiveamCode\LaravelNotionApi\Entities\Page;
use Mockery\MockInterface;

describe('Actions - NotionGetPageContentAction', function () {
    it('gets the page content as HTML', function () {
        // Arrange
        $pageData = [
            'id' => (string) Str::uuid(),
            'title' => 'How to upgrade to PHP 8.5',
            'properties' => [
                'URL' => ['url' => fake()->url()],
                'Status' => ['status' => ['name' => 'Done']],
                'Published' => ['date' => ['start' => now()->subWeeks(1)]],
                'Created' => ['created_time' => now()->subWeeks(2)],
                'Updated' => ['last_edited_time' => now()->subWeeks(2)],
            ],
        ];

        $page = mock(Page::class, function (MockInterface $mock) use ($pageData) {
            $mock->shouldReceive('getRawProperties')
                ->once()
                ->andReturn($pageData['properties']);

            $mock->shouldReceive('getId')
                ->once()
                ->andReturn($pageData['id']);

            $mock->shouldReceive('getTitle')
                ->once()
                ->andReturn($pageData['title']);
        });

        $pageContent = getTestData('page');

        $getPageContentAction = mock(NotionGetPageContentAction::class, function (MockInterface $mock) use ($page, $pageContent) {
            $mock->shouldReceive('execute')
                ->once()
                ->with($page)
                ->andReturn($pageContent);
        });

        // Act
        $result = resolve(NotionGetPageAction::class, ['getPageContentAction' => $getPageContentAction])->execute($page);

        // Assert
        expect($result)
            ->toBeArray()
            ->and($result['notion_id'])->toBe($pageData['id'])
            ->and($result['title'])->toBe($pageData['title'])
            ->and($result['slug'])->toBe($pageData['properties']['URL']['url'])
            ->and($result['content'])->toBe($pageContent)
            ->and($result['status'])->toBe($pageData['properties']['Status']['status']['name'])
            ->and($result['published_at'])->toBe($pageData['properties']['Published']['date']['start'])
            ->and($result['created_at'])->toBe($pageData['properties']['Created']['created_time'])
            ->and($result['updated_at'])->toBe($pageData['properties']['Updated']['last_edited_time']);
    });
});
