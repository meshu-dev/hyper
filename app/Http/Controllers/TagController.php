<?php

namespace App\Http\Controllers;

use App\Actions\Tag\GetListAction;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Get all tags
     */
    public function getAll(Request $request, GetListAction $getListAction)
    {
        $rows = $getListAction->execute($request->siteId);
        return response()->json($rows);
    }
}
