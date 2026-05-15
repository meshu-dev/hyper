<?php

namespace App\Actions\Notion\Block;

use FiveamCode\LaravelNotionApi\Entities\Page;
use Illuminate\Support\Carbon;

class NotionGetPageAction
{
    public function __construct(protected NotionGetPageContentAction $getPageContentAction)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function execute(Page $page): array
    {
        $pageContent = $this->getPageContentAction->execute($page);
        $properties = $page->getRawProperties();

        $slug = $properties['URL']['url'] ?? null;

        return [
            'notion_id' => $page->getId(),
            'title'        => $page->getTitle(),
            'slug'         => $slug,
            'content'      => $pageContent,
            'status'       => $properties['Status']['status']['name'],
            'published_at' => $properties['Published']['date']['start'] ?? null,
            'created_at'   => Carbon::parse($properties['Created']['created_time']),
            'updated_at'   => Carbon::parse($properties['Updated']['last_edited_time']),
        ];
    }
}
