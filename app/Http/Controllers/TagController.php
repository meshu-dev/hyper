<?php

namespace App\Http\Controllers;

use App\Actions\Tag\GetListAction;

class TagController extends Controller
{
    /**
     * Get all tags
     */
    public function getAll(GetListAction $getListAction, int $siteId)
    {
        $rows = $getListAction->execute($siteId);
        return response()->json($rows);
    }
}
