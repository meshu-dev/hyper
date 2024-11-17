<?php

namespace App\Services\Notion;

use App\Enums\SiteEnum;
use App\Models\{NotionBlog, Blog};
use App\Repositories\BlogRepository;
use Carbon\Carbon;
use FiveamCode\LaravelNotionApi\Entities\Page;

class NotionBlogService
{
    public function __construct(
        protected NotionPageService $notionPageService,
        protected BlogRepository $blogRepository
    ) {
    }

    public function add(SiteEnum $site, Page $page): Blog|null
    {
        $html        = $this->notionPageService->convertToHtml($page->getId());
        $properties  = $page->getRawProperties();

        $slug = $properties['URL']['url'] ?? null;

        // Skip blog creation if slug is blank
        if ($slug) {
            $blog = resolve(Blog::class);
            $blog->site_id = $site->value;
            $blog->title = $page->getTitle();
            $blog->slug = $slug;
            $blog->content = $html;
            $blog->status = $properties['Status']['status']['name'];
            $blog->published_at = $properties['Published']['date']['start'] ?? null;

            $notionBlog = NotionBlog::create([
                'notion_page_id' => $page->getId(),
                'created_at' => Carbon::parse($properties['Created']['created_time']),
                'updated_at' => Carbon::parse($properties['Updated']['last_edited_time'])
            ]);

            $blog->blogable()->associate($notionBlog);
            $blog->save();

            return $blog;
        }
        return null;
    }

    public function edit(Blog $blog, Page $page): bool
    {
        $html = $this->notionPageService->convertToHtml($page->getId());
        $properties = $page->getRawProperties();

        $blog->title = $page->getTitle();
        $blog->slug = $properties['URL']['url'] ?? null;
        $blog->content = $html;
        $blog->status = $properties['Status']['status']['name'];
        $isUpdated = $blog->save();

        $notionBlog = $blog->blogable;
        $notionBlog->updated_at = Carbon::parse($properties['Updated']['last_edited_time']);
        $notionBlog->save();

        return $isUpdated;
    }

    public function sync(SiteEnum $site, Page $page): Blog
    {
        $blog = $this->blogRepository->getByNotionPageId($page->getId());

        if ($blog) {
            $isPageUpdated = $this->isPageUpdated($page);

            if ($isPageUpdated) {
                $this->edit($blog, $page);
            }
        } else {
            $blog = $this->add($site, $page);
        }
        return $blog;
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
