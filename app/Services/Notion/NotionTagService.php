<?php

namespace App\Services\Notion;

use App\Enums\SiteEnum;
use App\Models\Blog;
use App\Repositories\TagRepository;
use FiveamCode\LaravelNotionApi\Entities\Page;

class NotionTagService
{
    public function __construct(
        protected TagRepository $tagRepository
    ) {
    }

    public function addTags(SiteEnum $site, Page $page): void
    {
        $properties = $page->getRawProperties();

        if (isset($properties['Tags'])) {
            $propertyTags = $properties['Tags']['multi_select'];

            foreach ($propertyTags as $propertyTag) {
                $tag = $this->tagRepository->getByNotionPageId($propertyTag['id']);

                if (!$tag) {
                    $propertyTag['site_id'] = $site->value;
                    $this->tagRepository->add($propertyTag);
                }
            }
        }
    }

    public function linkTagsToBlog(Page $page, Blog $blog): void
    {
        $properties = $page->getRawProperties();

        if (isset($properties['Tags'])) {
            $propertyTags = $properties['Tags']['multi_select'];
            $tagIds = [];

            foreach ($propertyTags as $propertyTag) {
                $tag = $this->tagRepository->getByNotionPageId($propertyTag['id']);
                $tagIds[] = $tag->id;
            }

            $blog->tags()->sync($tagIds);
        }
    }

    public function sync(SiteEnum $site, Page $page, Blog $blog)
    {
        $this->addTags($site, $page);
        $this->linkTagsToBlog($page, $blog);
    }
}
