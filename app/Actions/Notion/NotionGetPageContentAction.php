<?php

namespace App\Actions\Notion;

use App\Factories\NotionBlockFactory;
use FiveamCode\LaravelNotionApi\Entities\Page;
use FiveamCode\LaravelNotionApi\Notion;

class NotionGetPageContentAction
{
    protected Notion $notion;

    public function __construct(protected NotionGetPageBlocksAction $getPageBlocksAction)
    {
    }

    public function execute(Page $page)
    {
        $pageBlocks = $this->getPageBlocksAction->execute($page);
        $content = '';

        foreach ($pageBlocks as $pageBlock) {
            $content .= resolve(NotionBlockFactory::class)->make($pageBlock)->transform();
        }

        return $content;
    }
}
