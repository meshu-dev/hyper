<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\WpPost;

class WpPostRepository
{
    protected const PAGE_LIMIT = 10;

    public function getPaginated(): LengthAwarePaginator
    {
        return WpPost::latest()->paginate(self::PAGE_LIMIT);
    }

    public function get(int $id): WpPost
    {
        return WpPost::where('id', $id)->first();
    }

    public function getBySlug(string $slug): WpPost
    {
        return WpPost::where('slug', $slug)->first();
    }

    public function getAllUrls()
    {
        return WpPost::with(['wpPost' => function ($query) {
            $query->select('ID', 'post_name');
        }])->get();
    }

    public function getByWpPostId(int $wpPostId, bool $incDeleted = false): WpPost|null
    {
        $model = $incDeleted ? WpPost::withTrashed() : WpPost::select('*');
        return $model->where('wp_post_id', $wpPostId)->first();
    }

    public function add(array $params): WpPost
    {
        return WpPost::create([
            'wp_post_id'     => $params['wp_post_id'],
            'wp_category_id' => $params['wp_category_id'],
            'slug'           => $params['slug'],
            'content'        => $params['content']
        ]);
    }

    public function edit(int $id, array $params): bool
    {
        $post = WpPost::find($id);
        $post->wp_category_id = $params['wp_category_id'];
        $post->slug           = $params['slug'];
        $post->content        = $params['content'];
        return $post->save();
    }

    public function delete(int $id)
    {
        return WpPost::destroy($id);
    }
}
