<?php

namespace App\Actions\Notion\Import;

use App\Actions\Notion\Block\NotionGetPageAction;
use App\Enums\SiteEnum;
use App\Factories\NotionImportPageSiteActionFactory;
use App\Models\Blog;
use FiveamCode\LaravelNotionApi\Entities\Page;
use Illuminate\Support\Carbon;

class NotionImportPageAction
{
    public function __construct(
        protected NotionGetPageAction $getPageAction
    ) {
    }

    public function execute(Page $page, SiteEnum $site): void
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
            $params['site_id'] = $site->value;

            Blog::create($params);
        }

        resolve(NotionImportPageSiteActionFactory::class)->make($site)?->execute($page, $blog);
    }
}
