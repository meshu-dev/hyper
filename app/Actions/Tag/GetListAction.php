<?php

namespace App\Actions\Tag;

use App\Models\Tag;

class GetListAction
{
    public function execute()
    {
        return Tag::get()->pluck('name');
    }
}
