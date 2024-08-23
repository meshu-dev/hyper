<?php

namespace App\Actions\Blog;

use App\Enums\SiteEnum;
use App\Repositories\BlogRepository;
use App\Services\{
    NotionBlogService,
    NotionTagService
};
use Notion;

class ImportAction
{
    public function __construct(
        protected NotionBlogService $notionBlogService,
        protected NotionTagService $notionTagService,
        protected BlogRepository $blogRepository
    ) {
    }

    public function execute(SiteEnum $site)
    {
        $databaseId = config("sites.$site->value.notion_database_id");

        $pageCollection = Notion::database($databaseId)->query();
        $collectionOfPages = $pageCollection->asCollection();

        foreach ($collectionOfPages as $page) {
            $blog = $this->blogRepository->getByNotionPageId($page->getId());
            $doBlogTagSync = true;

            if ($blog) {
                $isPageUpdated = $this->notionBlogService->isPageUpdated($page);

                if ($isPageUpdated) {
                    $this->notionBlogService->edit($page);
                } else {
                    $doBlogTagSync = false;
                }
            } else {
                $blog = $this->notionBlogService->add($site, $page);
            }

            $this->notionTagService->addTags($site, $page);

            if ($doBlogTagSync) {
                $this->notionTagService->linkTagsToBlog($page, $blog);
            }
        }
    }
}
