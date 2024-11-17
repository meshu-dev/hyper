<?php

namespace App\Services\Notion;

use App\Enums\SiteEnum;
use App\Services\Notion\{
    NotionBlogService,
    NotionPageService,
    NotionTagService
};

class NotionImportService
{
    public function __construct(
        protected NotionPageService $notionPageService,
        protected NotionBlogService $notionBlogService,
        protected NotionTagService $notionTagService
    ) {
    }

    public function import(SiteEnum $site, string $databaseId): void
    {
        $pages = $this->notionPageService->getPages($databaseId);

        // Loop through pages and add or update existing DevNudge Notion blogs
        foreach ($pages as $page) {
            $blog = $this->notionBlogService->sync($site, $page);
            $this->notionTagService->sync($site, $page, $blog);
        }
    }
}
