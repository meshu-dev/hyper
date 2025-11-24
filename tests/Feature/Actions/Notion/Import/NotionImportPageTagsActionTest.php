<?php

use App\Actions\Notion\Import\NotionImportPageTagsAction;
use App\Enums\SiteEnum;
use App\Models\Tag;
use FiveamCode\LaravelNotionApi\Entities\Page;
use Illuminate\Support\Collection;
use Mockery\MockInterface;

describe('Actions - NotionImportPageTagsAction', function () {
    it('gets the page content as HTML', function () {
        // Arrange
        $pageData = [
            'id' => (string) Str::uuid(),
            'title' => 'How to install Drupal',
            'properties' => [
                'Tags' => [
                    'multi_select' => [
                        ['id' => 100, 'name' => 'Drupal', 'color' => 'blue']
                    ],
                ],
            ],
        ];

        $page = mock(Page::class, function (MockInterface $mock) use ($pageData) {
            $mock->shouldReceive('getRawProperties')
                ->once()
                ->andReturn($pageData['properties']);
        });

        $siteId = SiteEnum::DEVNUDGE->value;

        // Act
        $result = resolve(NotionImportPageTagsAction::class)->execute($page, $siteId);

        // Assert
        $tag = $pageData['properties']['Tags']['multi_select'][0];

        expect($result)
            ->toBeInstanceOf(Collection::class)
            ->and($result[0])
            ->toBeInstanceOf(Tag::class)
            ->and($result[0]->site_id)->toBe($siteId)
            ->and($result[0]->notion_tag_id)->toBe($tag['id'])
            ->and($result[0]->name)->toBe($tag['name'])
            ->and($result[0]->color)->toBe($tag['color']);
    });
});
