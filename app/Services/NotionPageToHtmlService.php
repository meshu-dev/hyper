<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Request;

class NotionPageToHtmlService
{
    public function convert(string $pageId): string
    {
        $converterUrl = config('services.notion.page_to_html.url');

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post(
                $converterUrl,
                ['pageId' => $pageId]
            );

        return $response->body();
    }
}
