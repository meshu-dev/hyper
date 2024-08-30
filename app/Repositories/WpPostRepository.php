<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Enums\SiteEnum;
use App\Models\{Blog, WpBlog};
use Carbon\Carbon;

class WpPostRepository
{
    protected const PAGE_LIMIT = 10;

    public function getPaginated(): LengthAwarePaginator
    {
        return WpBlog::latest()->paginate(self::PAGE_LIMIT);
    }

    public function get(int $id): Blog
    {
        return Blog::where('id', $id)->first();
    }

    public function getBySlug(string $slug): Blog
    {
        return Blog::where('slug', $slug)->first();
    }

    public function getAllUrls()
    {
        return Blog::with(['wpPost' => function ($query) {
            $query->select('ID', 'post_name');
        }])->get();
    }

    public function getByWpPostId(int $wpPostId, bool $incDeleted = false): Blog|null
    {
        $model = Blog::select('*');
        return $model->where('wp_post_id', $wpPostId)->first();
    }

    public function add(array $params): Blog
    {
        $blog = resolve(Blog::class);
        $blog->site_id = SiteEnum::DEV_PUSH->value;
        $blog->title = $params['title'];
        $blog->slug = $params['slug'] ?? null;
        $blog->content = $params['content'];
        $blog->status = 'Done';
        $blog->published_at = $params['published_at'];

        $wpBlog = WpBlog::create([
            'wp_post_id'     => $params['wp_post_id'],
            'wp_category_id' => $params['wp_category_id'],
            'updated_at'     => $params['post_modified']
        ]);

        $blog->blogable()->associate($wpBlog);
        $blog->save();

        return $blog;
    }

    public function edit(int $id, array $params): bool
    {
        $post = Blog::find($id);
        $post->title          = $params['title'];
        $post->slug           = $params['slug'];
        $post->content        = $params['content'];
        $post->published_at   = $params['published_at'];
        return $post->save();
    }

    public function delete(int $id)
    {
        return WpBlog::destroy($id);
    }
}
