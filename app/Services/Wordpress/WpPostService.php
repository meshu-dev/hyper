<?php

namespace App\Services\Wordpress;

use App\Repositories\{
    WpPostRepository,
    WpBlogRepository,
    WpPostCategoryRepository
};

class WpPostService
{
    public function __construct(
        protected WpPostRepository $postRepository,
        protected WpBlogRepository $wpBlogRepository,
        protected WpPostCategoryRepository $postCategoryRepository
    ) {
    }

    public function processPost($wpPost)
    {
        $wpPostId = (int) $wpPost->ID;
        $categoryTaxonomy = $wpPost->taxonomies()->first();

        $params = [
            'wp_category_id' => $categoryTaxonomy->term->term_id ?? 0,
            'title'          => $wpPost->post_title,
            'slug'           => $wpPost->slug,
            'content'        => $wpPost->post_content,
            'published_at'   => $wpPost->post_date,
            'post_modified'  => $wpPost->post_modified
        ];

        $wpBlog        = $this->wpBlogRepository->getByWpPostId($wpPostId, true);
        $isPostDeleted = strpos($wpPost->slug, '__trashed') !== false;

        if ($wpBlog) {
            $blogId = $wpBlog->blog->id;

            if ($isPostDeleted) {
                $this->postRepository->delete($blogId);
            } else {
                $this->postRepository->edit(
                    $blogId,
                    $params
                );
            }
        } else {
            $params['wp_post_id'] = $wpPostId;
            $post = $this->postRepository->add($params);

            if ($isPostDeleted) {
                $this->postRepository->delete($post->id);
            }
        }
    }

    public function processPostCategory($wpCategory)
    {
        /*
        $wpCategoryId = (int) $wpCategory->term_id;
        $postCategory = $this->postCategoryRepository->getByWordpressCategoryId($wpCategoryId);
        $params       = ['name' => $wpCategory->name];

        if ($postCategory) {
            $this->postCategoryRepository->edit(
                $postCategory->id,
                $params
            );
        } else {
            $params['wp_category_id'] = $wpCategoryId;
            $this->postCategoryRepository->add($params);
        } */
    }
}
