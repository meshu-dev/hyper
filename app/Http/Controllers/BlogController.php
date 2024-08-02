<?php

namespace App\Http\Controllers;

use App\Actions\Blog\{
    GetPublishedListAction,
    GetPublishedBySearchAction,
    GetPublishedBySlugAction,
    GetPublishedByTagAction
};

class BlogController extends Controller
{
    /**
     * Get all blogs with a published date
     */
    public function getPublished(GetPublishedListAction $getPublishedListAction)
    {
        $rows = $getPublishedListAction->execute();
        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided slug
     */
    public function getPublishedBySlug(GetPublishedBySlugAction $getBySlugAction, string $slug)
    {
        $row = $getBySlugAction->execute($slug);
        return response()->json($row);
    }

    /**
     * Get published blogs that are associated with provided tag
     */
    public function getPublishedByTag(GetPublishedByTagAction $getByTagAction, string $tagName)
    {
        $rows = $getByTagAction->execute($tagName);
        return response()->json($rows);
    }

    /**
     * Get published blog that matches provided search term
     */
    public function getPublishedBySearch(GetPublishedBySearchAction $getBySearchAction, string $search)
    {
        $rows = $getBySearchAction->execute($search);
        return response()->json($rows);
    }
}
