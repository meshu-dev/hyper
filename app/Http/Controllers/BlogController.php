<?php

namespace App\Http\Controllers;

use App\Actions\Blog\{
    GetBySlugAction,
    GetByTagAction,
    GetListAction,
    GetSlugListAction,
    SearchAction
};

class BlogController extends Controller
{
    /**
     * Get all blogs with a published date
     */
    public function getList(GetListAction $getListAction)
    {
        $rows = $getListAction->execute();
        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided slug
     */
    public function getBySlug(GetBySlugAction $getBySlugAction, string $slug)
    {
        $row = $getBySlugAction->execute($slug);
        return response()->json($row);
    }

    /**
     * Get published blogs that are associated with provided tag
     */
    public function getByTag(GetByTagAction $getByTagAction, string $tagName)
    {
        $rows = $getByTagAction->execute($tagName);
        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided search term
     */
    public function search(SearchAction $getBySearchAction, string $search)
    {
        $rows = $getBySearchAction->execute($search);
        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided search term
     */
    public function getSlugs(GetSlugListAction $getSlugListAction)
    {
        $rows = $getSlugListAction->execute();
        return response()->json($rows);
    }
}
