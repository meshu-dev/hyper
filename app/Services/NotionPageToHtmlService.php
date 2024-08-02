<?php

namespace App\Services;

class NotionPageToHtmlService
{
    public function convert(string $pageId)
    {
        $apiUrl = config('services.notion.api.url');

        $request = $this->getRequest();
        $response = $request->post("$apiUrl/databases/$databaseId/query", '{}');

        return $response->body();
    }
}
