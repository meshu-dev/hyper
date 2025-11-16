<?php

namespace App\Http\Controllers;

use App\Actions\Tag\GetListAction;
use App\Http\Resources\TagListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagController extends Controller
{
    /**
     * Get all tags
     */
    public function getAll(Request $request, GetListAction $getListAction): JsonResource
    {
        $tags = $getListAction->execute($request->siteId);

        return TagListResource::collection($tags);
    }
}
