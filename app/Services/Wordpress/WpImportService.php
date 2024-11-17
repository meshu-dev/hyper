<?php

namespace App\Services\Wordpress;

use App\Exceptions\WpPostSlugBlankException;
use App\Repositories\Wordpress\{WpPostRepository, WpTaxonomyRepository};

class WpImportService
{
    public function __construct(
        protected WpPostRepository $wpPostRepository,
        protected WpTaxonomyRepository $wpTaxonomyRepository,
        protected WpPostService $postService
    ) {
    }

    public function import(): void
    {
        $this->importPosts();
        $this->importCategories();
    }

    public function importPosts(): void
    {
        $wpPosts = $this->wpPostRepository->getAll();

        foreach ($wpPosts as $wpPost) {
            throw_if(
                !$wpPost->slug,
                WpPostSlugBlankException::class,
                'Wordpress post with ID ' . $wpPost->ID . ' has a blank slug'
            );

            $this->postService->processPost($wpPost);
        }
    }

    public function importCategories(): void
    {
        $wpCategories = $this->wpTaxonomyRepository->getCategories();

        foreach ($wpCategories as $wpCategory) {
            $this->postService->processPostCategory($wpCategory);
        }
    }
}
