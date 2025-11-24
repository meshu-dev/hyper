<?php

namespace App\Actions\Notion\Api;

use FiveamCode\LaravelNotionApi\Notion;
use Illuminate\Support\Collection;

class NotionApiGetAction
{
    protected Notion $notion;

    public function __construct()
    {
        $this->notion = resolve(
            Notion::class,
            ['token' => config('services.notion.api_key')]
        );
    }

    /**
     * @return Collection<int, mixed>
     */
    public function execute(string $pageId): Collection
    {
        return $this->notion
            ->block($pageId)
            ->children()
            ->asCollection();
    }
}
