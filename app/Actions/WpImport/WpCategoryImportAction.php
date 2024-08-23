<?php

namespace App\Actions\WpImport;

use App\Repositories\Wordpress\WpTaxonomyRepository;
use App\Services\WpPostService;

class WpCategoryImportAction
{
    public function __construct(
        protected WpTaxonomyRepository $wpTaxonomyRepository,
        protected WpPostService $postService
    ) {
    }

    public function execute(): void
    {
        $wpCategories = $this->wpTaxonomyRepository->getCategories();

        foreach ($wpCategories as $wpCategory) {
            $this->postService->processPostCategory($wpCategory);
        }
    }
}
