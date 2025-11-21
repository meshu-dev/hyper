<?php

namespace App\Http\Controllers;

use App\Actions\Blog\{
    GetBySlugAction,
    GetByTagAction,
    GetListAction,
    GetSlugListAction,
    SearchAction,
};
use App\Http\Resources\{
    BlogListResource,
    BlogResource,
};
use Illuminate\Http\{
    JsonResponse,
    Request,
};
use Illuminate\Http\Resources\Json\JsonResource;

class BlogController extends Controller
{
    /**
     * Get all blogs with a published date
     */
    public function getList(Request $request, GetListAction $getListAction): JsonResource
    {
        $perPage = $request->query('per_page', config('blog.items_per_page'));
        $blogs = $getListAction->execute($request->siteId, $perPage);

        return BlogListResource::collection($blogs);
    }

    /**
     * Get published blog that matches provided slug
     */
    public function getBySlug(Request $request, GetBySlugAction $getBySlugAction): JsonResource
    {
        $slug = $request->route('slug');
        $blog = $getBySlugAction->execute($request->siteId, $slug);

        return resolve(BlogResource::class, ['resource' => $blog]);
    }

    /**
     * Get published blogs that are associated with provided tag
     */
    public function getByTag(Request $request, GetByTagAction $getByTagAction): JsonResource
    {
        $tag = $request->route('tag');
        $paginator = $getByTagAction->execute($request->siteId, $tag);

        return BlogListResource::collection($paginator);
    }

    /**
     * Get published blog that matches provided search term
     */
    public function search(Request $request, SearchAction $getBySearchAction): JsonResource
    {
        $search = $request->route('search');
        $paginator = $getBySearchAction->execute($request->siteId, $search);

        return BlogListResource::collection($paginator);
    }

    /**
     * Get published blog that matches provided search term
     */
    public function getSlugs(Request $request, GetSlugListAction $getSlugListAction): JsonResponse
    {
        $rows = $getSlugListAction->execute($request->siteId);
        return response()->json(['data' => $rows]);
    }
}
