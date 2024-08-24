<?php

namespace App\Http\Controllers;

use App\Actions\Blog\{
    GetBySlugAction,
    GetByTagAction,
    GetListAction,
    GetSlugListAction,
    SearchAction,
    GetTotalPagesAction,
    GetLatestAction
};

class BlogController extends Controller
{
    /**
     * Get all blogs with a published date
     */
    public function getList(GetListAction $getListAction, int $siteId)
    {
        $rows = $getListAction->execute($siteId);
        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided slug
     */
    public function getBySlug(GetBySlugAction $getBySlugAction, int $siteId, string $slug)
    {
        $row = $getBySlugAction->execute($siteId, $slug);
        return response()->json($row);
    }

    /**
     * Get published blogs that are associated with provided tag
     */
    public function getByTag(GetByTagAction $getByTagAction, int $siteId, string $tagName)
    {
        $rows = $getByTagAction->execute($siteId, $tagName);
        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided search term
     */
    public function search(SearchAction $getBySearchAction, int $siteId, string $search)
    {
        $rows = $getBySearchAction->execute($siteId, $search);
        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided search term
     */
    public function getSlugs(GetSlugListAction $getSlugListAction, int $siteId)
    {
        $rows = $getSlugListAction->execute($siteId);
        return response()->json($rows);
    }

    /**
     * Get total pages of published blogs
     */
    public function getTotalPages(GetTotalPagesAction $getTotalPagesAction, int $siteId)
    {
        $totalPages = $getTotalPagesAction->execute($siteId);
        return response()->json(['total_pages' => $totalPages]);
    }

    /**
     * Get total pages of published blogs
     */
    public function getLatest(GetLatestAction $getLatestAction, int $siteId)
    {
        $rows = $getLatestAction->execute($siteId);
        return response()->json($rows);
    }
}
