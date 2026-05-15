<?php

namespace App\Actions\Image;

use App\Models\Image;

class GetImageAction
{
    /**
     * @return Image
     */
    public function execute(string $notionId, string $filename): Image|null
    {
        return Image::where('notion_id', $notionId)
                    ->where('filename', $filename)
                    ->first();
    }
}
