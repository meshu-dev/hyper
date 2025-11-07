<?php

namespace App\Actions\Notion;

use App\Models\Tag;
use FiveamCode\LaravelNotionApi\Entities\Page;
use Illuminate\Support\Collection;

class NotionImportPageTagsAction
{
    public function execute(Page $page, int $siteId): ?Collection
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
