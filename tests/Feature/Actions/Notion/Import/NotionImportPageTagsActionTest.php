<?php

use App\Actions\Notion\Import\NotionImportPageTagsAction;
use App\Enums\SiteEnum;
use App\Models\Blog;
use FiveamCode\LaravelNotionApi\Entities\Page;
use Mockery\MockInterface;

describe('Actions - NotionImportPageTagsAction', function () {
    it('gets the page content as HTML', function () {
        // Arrange
        $blog = Blog::factory()->create();

        $pageData = [
            'id' => $blog->notion_id,
            'title' => 'How to install Drupal',
            'properties' => [
                'Tags' => [
                    'multi_select' => [
                        ['id' => 100, 'name' => 'Drupal', 'color' => 'blue'],
                    ],
                ],
            ],
        ];

        // Assert
        $page = mock(Page::class, function (MockInterface $mock) use ($pageData) {
            $mock->shouldReceive('getId')
                ->once()
                ->andReturn($pageData['id']);

            $mock->shouldReceive('getRawProperties')
                ->once()
                ->andReturn($pageData['properties']);
        });

        $siteId = SiteEnum::DEVNUDGE->value;

        // Act
        resolve(NotionImportPageTagsAction::class)->execute($page, $siteId);
    });
});
