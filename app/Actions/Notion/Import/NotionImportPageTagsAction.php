<?php

namespace App\Actions\Notion\Import;

use App\Actions\Blog\SyncBlogTagsAction;
use App\Models\Blog;
use App\Models\Tag;
use FiveamCode\LaravelNotionApi\Entities\Page;
use Illuminate\Support\Collection;

class NotionImportPageTagsAction
{
    public function __construct(
        protected SyncBlogTagsAction $syncBlogTagsAction
    ) {
    }

    public function execute(Page $page, int $siteId): void
    {
        $blog = Blog::where('notion_id', $page->getId())->first();
        $tags = $this->addTags($page, $siteId);

        if ($blog && $tags) {
            $this->syncBlogTagsAction->execute($blog, $tags);
        }
    }

    /**
     * @return Collection<int, Tag>|null
     */
    protected function addTags(Page $page, int $siteId): ?Collection
    {
        $properties = $page->getRawProperties();
        $tags = [];

        if (isset($properties['Tags'])) {
            $propertyTags = $properties['Tags']['multi_select'];

            foreach ($propertyTags as $propertyTag) {
                $tags[] = $this->addTag($propertyTag, $siteId);
            }

            return collect($tags);
        }
        return null;
    }

    /**
     * @param array<string, mixed> $propertyTag
     */
    protected function addTag(array $propertyTag, int $siteId): Tag
    {
        $tag = Tag::where('site_id', $siteId)->where('notion_tag_id', $propertyTag['id'])->first();

        if (! $tag) {
            $tag = Tag::create([
                'site_id' => $siteId,
                'notion_tag_id' => $propertyTag['id'],
                'name' => $propertyTag['name'],
                'color' => $propertyTag['color'],
            ]);
        }

        return $tag;
    }
}
