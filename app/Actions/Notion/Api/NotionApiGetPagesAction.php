<?php

namespace App\Actions\Notion\Api;

use Illuminate\Support\Collection;

class NotionApiGetPagesAction extends NotionBaseApiAction
{
    /**
     * @return Collection<int, mixed>
     */
    public function execute(string $databaseId): Collection
    {   
        return $this->notion
            ->database($databaseId)
            ->query()
            ->asCollection();
    }
}
