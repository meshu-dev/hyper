<?php

namespace App\Actions\Notion\Import;

use App\Actions\Notion\Api\NotionApiGetPagesAction;

class NotionImportDatabaseAction
{
    public function __construct(
        protected NotionApiGetPagesAction $notionApiGetPagesAction,
        protected NotionImportPageAction $notionImportPageAction,
        protected NotionImportPageTagsAction $notionImportPageTagsAction
    )
    {
    }

    public function execute(string $databaseId, int $siteId): void
    {
        $pages = $this->notionApiGetPagesAction->execute($databaseId);

        foreach ($pages as $page) {
            $this->notionImportPageAction->execute($page, $siteId);
            $this->notionImportPageTagsAction->execute($page, $siteId);
        }
    }
}
