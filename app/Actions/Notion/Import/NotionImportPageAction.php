<?php

namespace App\Actions\Notion\Import;

use App\Actions\Notion\Block\NotionGetPageAction;
use App\Models\Blog;
use FiveamCode\LaravelNotionApi\Entities\Page;
use Illuminate\Support\Carbon;

class NotionImportPageAction
{
    public function __construct(
        protected NotionGetPageAction $getPageAction
    )
    {
    }

    public function execute(Page $page, int $siteId): void
    {
        $blog = Blog::where('notion_id', $page->getId())->first();
        $updatedAt = Carbon::parse($page->getProperty('Updated')?->getContent());

        if (
            $blog &&
            $blog->updated_at?->lessThan($updatedAt)
        ) {
            Blog::where('notion_id', $page->getId())->update($this->getPageAction->execute($page));
        } elseif (!$blog) {
            $params = $this->getPageAction->execute($page);
            $params['site_id'] = $siteId;

            Blog::create($params);
        }
    }
}
