<?php

namespace App\Services;

use App\Enums\SiteEnum;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use Carbon\Carbon;

class NotionBlogService
{
    public function __construct(
        protected NotionPageToHtmlService $pageToHtmlService,
        protected BlogRepository $blogRepository
    ) {
    }

    public function add(SiteEnum $site, $page): Blog|null
    {
        $html = $this->pageToHtmlService->convert($page->getId());
        $properties = $page->getRawProperties();

        return Blog::create([
            'site_id'        => $site->value,
            'notion_page_id' => $page->getId(),
            'title'          => $page->getTitle(),
            'slug'           => $properties['URL']['url'] ?? null,
            'content'        => $html,
            'status'         => $properties['Status']['status']['name'],
            'published_at'   => $properties['Published']['date']['start'] ?? null,
            'created_at'     => Carbon::parse($properties['Created']['created_time']),
            'updated_at'     => Carbon::parse($properties['Updated']['last_edited_time'])
        ]);
    }

    public function edit($page): bool
    {
        $html = $this->pageToHtmlService->convert($page->getId());
        $properties = $page->getRawProperties();

        $params = [
            'title'      => $page->getTitle(),
            'slug'       => $properties['URL']['url'] ?? null,
            'content'    => $html,
            'updated_at' => Carbon::parse($properties['Updated']['last_edited_time'])
        ];

        $isUpdated = Blog::where('notion_page_id', $page->getId())
                          ->update($params);

        return $isUpdated;
    }

    public function hasBlog(string $pageId): bool
    {
        $blog = $this->blogRepository->getByNotionPageId($pageId);
        return $blog ? true : false;
    }

    public function isPageUpdated($page): bool
    {
        $properties = $page->getRawProperties();
        $pageLastUpdated = Carbon::parse($properties['Updated']['last_edited_time']);

        $blog = $this->blogRepository->getByNotionPageId(
            $page->getId()
        );
        $blogLastUpdated = Carbon::parse($blog->updated_at);

        return $pageLastUpdated->greaterThan($blogLastUpdated);
    }
}
