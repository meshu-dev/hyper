<?php

namespace App\Actions\Notion\Api;

use FiveamCode\LaravelNotionApi\Notion;

abstract class NotionBaseApiAction
{
    protected Notion $notion;

    public function __construct()
    {
        $this->notion = resolve(
            Notion::class,
            ['token' => config('services.notion.api_key')]
        );
    }
}
