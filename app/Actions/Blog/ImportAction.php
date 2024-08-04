<?php

namespace App\Actions\Blog;

use App\Services\NotionPageToHtmlService;
use App\Models\{Blog, Tag};
use Carbon\Carbon;
use Notion;

class ImportAction
{
    public function __construct(
        protected NotionPageToHtmlService $pageToHtmlService
    ) {
    }

    public function execute()
    {
        $databaseId = config('services.notion.api.database_id');

        $pageCollection = Notion::database($databaseId)->query();
        $collectionOfPages = $pageCollection->asCollection();

        foreach ($collectionOfPages as $page) {
            $properties = $page->getRawProperties();

            $blog = Blog::where('notion_page_id', $page->getId())->first();

            if (!$blog) {
                $html = $this->pageToHtmlService->convert($page->getId());

                $blog = Blog::create([
                    'notion_page_id' => $page->getId(),
                    'title'          => $page->getTitle(),
                    'slug'           => $properties['URL']['url'] ?? null,
                    'content'        => $html,
                    'status'         => $properties['Status']['status']['name'],
                    'published_at'   => $properties['Published']['date']['start'] ?? null,
                    'created_at'     => Carbon::parse($properties['Created']['created_time']),
                    'updated_at'     => Carbon::parse($properties['Updated']['last_edited_time'])
                ]);

                if (isset($properties['Tags'])) {
                    $propertyTags = $properties['Tags']['multi_select'];

                    foreach ($propertyTags as $propertyTag) {
                        $tag = Tag::where('notion_tag_id', $propertyTag['id'])->first();

                        if (!$tag) {
                            $tag = Tag::create([
                                'notion_tag_id' => $propertyTag['id'],
                                'name'          => $propertyTag['name'],
                                'color'         => $propertyTag['color']
                            ]);
                        }

                        $blog->tags()->save($tag);
                    }
                }
            }
        }

        dd('$collectionOfPages', $collectionOfPages);
    }
}
