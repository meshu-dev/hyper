<?php

namespace App\Http\Controllers;

use App\Actions\Tag\GetListAction;

class TagController extends Controller
{
    /**
     * Get all tags
     */
    public function getAll(GetListAction $getListAction)
    {
        $rows = $getListAction->execute();
        return response()->json($rows);
    }
}
