<?php

namespace App\Services;

use App\Models\Blog;
use App\Repositories\TagRepository;

class NotionTagService
{
    public function __construct(
        protected TagRepository $tagRepository
    ) {
    }

    public function addTags($page): void
    {
        $properties = $page->getRawProperties();

        if (isset($properties['Tags'])) {
            $propertyTags = $properties['Tags']['multi_select'];

            foreach ($propertyTags as $propertyTag) {
                $tag = $this->tagRepository->getByNotionPageId($propertyTag['id']);

                if (!$tag) {
                    $this->tagRepository->add($propertyTag);
                }
            }
        }
    }

    public function linkTagsToBlog($page, Blog $blog): void
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
}
