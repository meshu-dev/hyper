<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use App\Models\WpPostCategory;

class WpPostCategoryRepository
{
    public function getAll(): Collection
    {
        return WpPostCategory::with('wpCategory')->get();
    }

    public function getByWordpressCategoryId(int $wpCategoryId): WpPostCategory|null
    {
        return WpPostCategory::where('wp_category_id', $wpCategoryId)->first();
    }

    public function add(array $params): WpPostCategory
    {
        return WpPostCategory::create([
            'wp_category_id' => $params['wp_category_id'],
            'name'           => $params['name']
        ]);
    }

    public function edit(int $id, array $params): bool
    {
        $postCategory = WpPostCategory::find($id);
        $postCategory->name = $params['name'];
        return $postCategory->save();
    }
}
