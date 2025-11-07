<?php

namespace App\Actions\Notion;

use FiveamCode\LaravelNotionApi\Entities\Page;
use FiveamCode\LaravelNotionApi\Notion;

class NotionGetPageAction
{
    protected Notion $notion;

    protected NotionGetPageContentAction $getPageContentAction;

    public function __construct()
    {
        $this->notion = resolve(
            Notion::class,
            ['token' => config('services.notion.api_key')]
        );
        $this->getPageContentAction = resolve(
            NotionGetPageContentAction::class
        );
    }

    public function execute(Page $page): array
    {
        $pageContent = $this->getPageContentAction->execute($page);
        $properties = $page->getRawProperties();

        $slug = $properties['URL']['url'] ?? null;

        return [
            'notion_id' => $page->getId(),
            'title' => $page->getTitle(),
            'slug' => $slug,
            'content' => $pageContent,
            'status' => $properties['Status']['status']['name'],
            'published_at' => $properties['Published']['date']['start'] ?? null,
            'created_at' => $properties['Created']['created_time'],
            'updated_at' => $properties['Updated']['last_edited_time'],
        ];
    }
}
