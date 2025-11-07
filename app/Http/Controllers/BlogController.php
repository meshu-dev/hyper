<?php

namespace App\Http\Controllers;

use App\Actions\Blog\GetBySlugAction;
use App\Actions\Blog\GetByTagAction;
use App\Actions\Blog\GetLatestAction;
use App\Actions\Blog\GetListAction;
use App\Actions\Blog\GetSlugListAction;
use App\Actions\Blog\GetTotalPagesAction;
use App\Actions\Blog\SearchAction;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Get all blogs with a published date
     */
    public function getList(Request $request, GetListAction $getListAction)
    {
        $rows = $getListAction->execute($request->siteId);

        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided slug
     */
    public function getBySlug(Request $request, GetBySlugAction $getBySlugAction)
    {
        $slug = $request->route('slug');
        $row = $getBySlugAction->execute($request->siteId, $slug);

        return response()->json($row);
    }

    /**
     * Get published blogs that are associated with provided tag
     */
    public function getByTag(Request $request, GetByTagAction $getByTagAction)
    {
        $tag = $request->route('tag');
        $rows = $getByTagAction->execute($request->siteId, $tag);

        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided search term
     */
    public function search(Request $request, SearchAction $getBySearchAction)
    {
        $search = $request->route('search');
        $rows = $getBySearchAction->execute($request->siteId, $search);

        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided search term
     */
    public function getSlugs(Request $request, GetSlugListAction $getSlugListAction)
    {
        $rows = $getSlugListAction->execute($request->siteId);

        return response()->json($rows);
    }

    /**
     * Get total pages of published blogs
     */
    public function getTotalPages(Request $request, GetTotalPagesAction $getTotalPagesAction)
    {
        $totalPages = $getTotalPagesAction->execute($request->siteId);

        return response()->json(['total_pages' => $totalPages]);
    }

    /**
     * Get total pages of published blogs
     */
    public function getLatest(Request $request, GetLatestAction $getLatestAction)
    {
        $rows = $getLatestAction->execute($request->siteId);

        return response()->json($rows);
    }
}
