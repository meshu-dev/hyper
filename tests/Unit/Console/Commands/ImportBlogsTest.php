<?php

use App\Actions\Notion\NotionImportPagesAction;
use App\Enums\SiteEnum;
use Mockery\MockInterface;

describe('Commands - ImportBlogs', function () {
    it('runs the import blog command', function () {
        // Assert
        $action = mock(NotionImportPagesAction::class, function (MockInterface $mock) {
            $databaseId = config('services.notion.devnudge.database_id');
            $siteId = SiteEnum::DEVNUDGE->value;

            $mock->shouldReceive('execute')
                ->once()
                ->with($databaseId, $siteId);
        });

        $this->app->bind(NotionImportPagesAction::class, fn () => $action);

        // Act
        $this->artisan('app:import-blogs')->assertSuccessful();
    });
});
