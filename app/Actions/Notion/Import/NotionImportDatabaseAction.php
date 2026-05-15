<?php

namespace App\Actions\Notion\Import;

use App\Actions\Notion\Api\NotionApiGetPagesAction;
use App\Enums\SiteEnum;

class NotionImportDatabaseAction
{
    public function __construct(
        protected NotionApiGetPagesAction $notionApiGetPagesAction,
        protected NotionImportPageAction $notionImportPageAction,
        protected NotionImportPageTagsAction $notionImportPageTagsAction
    ) {
    }

    public function execute(string $databaseId, SiteEnum $site): void
    {
        $pages = $this->notionApiGetPagesAction->execute($databaseId);

        foreach ($pages as $page) {
            $this->notionImportPageAction->execute($page, $site);
            $this->notionImportPageTagsAction->execute($page, $site);

            dump('PAGE!', $page->getUrl());
        }
    }
}
