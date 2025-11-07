<?php

namespace App\Actions\Notion;

use App\Actions\Blog\SyncBlogTagsAction;
use App\Models\Blog;
use FiveamCode\LaravelNotionApi\Entities\Page;
use FiveamCode\LaravelNotionApi\Notion;
use Illuminate\Support\Carbon;

class NotionImportPagesAction
{
    protected Notion $notion;

    protected NotionGetPageAction $getPageAction;

    protected NotionImportPageTagsAction $importPageTagsAction;

    protected SyncBlogTagsAction $syncBlogTagsAction;

    public function __construct()
    {
        $this->notion = resolve(
            Notion::class,
            ['token' => config('services.notion.api_key')]
        );

        $this->getPageAction = resolve(NotionGetPageAction::class);
        $this->importPageTagsAction = resolve(NotionImportPageTagsAction::class);
        $this->syncBlogTagsAction = resolve(SyncBlogTagsAction::class);
    }

    public function execute(string $databaseId, int $siteId): void
    {
        $pages = $this->notion->database($databaseId)->query()->asCollection();

        foreach ($pages as $page) {
            $blog = $this->importPage($page, $siteId);

            $tags = $this->importPageTagsAction->execute($page, $siteId);
            $this->syncBlogTagsAction->execute($blog, $tags);
        }
    }

    protected function importPage(Page $page, int $siteId): Blog
    {
        $blog = Blog::where('notion_id', $page->getId())->first();
        $updatedAt = Carbon::parse($page->getProperty('Updated')->getContent());

        if (
            $blog &&
            $blog->updated_at->lessThan($updatedAt)
        ) {
            Blog::where('notion_id', $page->getId())->update($this->getPageAction->execute($page));
        } elseif (! $blog) {
            $params = $this->getPageAction->execute($page);
            $params['site_id'] = $siteId;

            Blog::create($params);
        }

        return Blog::where('notion_id', $page->getId())->first();
    }
}
