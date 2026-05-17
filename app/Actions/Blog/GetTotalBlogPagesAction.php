<?php

namespace App\Actions\Blog;

class GetTotalBlogPagesAction
{
    /**
     * @return int
     */
    public function execute(int $siteId): int
    {
        return resolve(GetListAction::class)->execute($siteId)->lastPage();
    }
}
