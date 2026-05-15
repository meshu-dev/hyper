<?php

namespace App\Transformers\Notion;

use App\Actions\Image\GetImageAction;
use App\Actions\Image\UploadImageAction;
use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Image;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Uri;

class NotionImageTransformer implements NotionTransformer
{
    public function __construct(protected Image $block)
    {
    }

    public function transform(): string
    {
        $filename = $this->getImageUrl($this->block->getContent());
        $imageUrl  = Storage::url($filename);

        return "<img src='$imageUrl' />";
    }

    private function getImageUrl(string $url)
    {
        $uri      = Uri::of($url);

        $pageId   = $this->getPageId();
        $filename = $uri->pathSegments()->last();

        $image = resolve(GetImageAction::class)->execute($pageId, $filename);

        if (!$image) {
            $filePath = storage_path("app/private/$filename");
            Http::sink($filePath)->timeout(60)->get($url);

            $image = resolve(UploadImageAction::class)->execute(
                $this->getPageId(),
                $filename,
                $filePath
            );
        }
        return $image->url;
    }

    public function getPageId(): string|null
    {
        $blockResponse = $this->block->getRawResponse();

        return $blockResponse['parent']['page_id'] ?: null;
    }
}
