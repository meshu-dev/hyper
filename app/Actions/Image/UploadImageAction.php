<?php

namespace App\Actions\Image;

use App\Models\Image;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use UnhandledMatchError;

class UploadImageAction
{
    /**
     * @return Image
     */
    public function execute(string $notionId, string $filename, string $filePath): Image|null
    {
        $fileDriver = config('filesystems.default');

        $fileUrl = match ($fileDriver) {
            'local' => Storage::putFile('images', $filePath),
            's3'    => Storage::putFileAs('images', new File($filePath), Str::uuid(), 'public'),
            default => new UnhandledMatchError(),
        };

        return Image::create([
            'notion_id' => $notionId,
            'filename'  => $filename,
            'url'       => $fileUrl,
        ]);
    }
}
