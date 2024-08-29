<?php

namespace App\Services;

use App\Enums\SiteEnum;
use App\Models\{NotionBlog, Blog};
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

        $blog = resolve(Blog::class);
        $blog->site_id = $site->value;
        $blog->title = $page->getTitle();
        $blog->slug = $properties['URL']['url'] ?? null;
        $blog->content = $html;
        $blog->status = $properties['Status']['status']['name'];
        $blog->published_at = $properties['Published']['date']['start'] ?? null;
        $blog->created_at = Carbon::parse($properties['Created']['created_time']);
        $blog->updated_at = Carbon::parse($properties['Updated']['last_edited_time']);

        $notionBlog = NotionBlog::create([
            'notion_page_id' => $page->getId()
        ]);

        $blog->blogable()->associate($notionBlog);
        $blog->save();

        return $blog;
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
