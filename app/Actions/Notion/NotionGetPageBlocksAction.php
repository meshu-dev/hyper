<?php

namespace App\Actions\Notion;

use App\Collections\{
    BulletItemCollection,
    NumberedItemCollection,
};
use FiveamCode\LaravelNotionApi\Entities\Blocks\{
    BulletedListItem,
    NumberedListItem,
};
use FiveamCode\LaravelNotionApi\Notion;
use FiveamCode\LaravelNotionApi\Entities\Page;
use Illuminate\Support\Collection;

class NotionGetPageBlocksAction
{
    protected Notion $notion;

    public function __construct()
    {
        $this->notion = resolve(
            Notion::class,
            ['token' => config('services.notion.api_key')]
        );
    }

    public function execute(Page $page)
    {
        $pageBlocks = $this->notion
                           ->block($page->getId())
                           ->children()
                           ->asCollection();

        $pageBlocksLength = count($pageBlocks);
        $pageItems        = [];

        for ($i = 0; $i < $pageBlocksLength; $i++) {
            $block = $pageBlocks[$i] ?? null;

            if (!$block) {
                break;
            }

            if (
                $block instanceof BulletedListItem ||
                $block instanceof NumberedListItem
            ) {
                $collection = $this->groupBulletItems($pageBlocks, $i, $block::class);
                $i += ($collection->count() - 1);

                $pageItems[] = $collection;
            } else {
                $pageItems[] = $block;
            }
        }

        return $pageItems;
    }

    protected function groupBulletItems($pageBlocks, $index, $type): Collection
    {
        $group = [$pageBlocks[$index]];
        $index++;

        while ($pageBlocks[$index] instanceof $type) {
            $group[] = $pageBlocks[$index];
            $index++;
        }

        return match ($type) {
            BulletedListItem::class => resolve(BulletItemCollection::class, ['items' => $group]),
            NumberedListItem::class => resolve(NumberedItemCollection::class, ['items' => $group]),
        };
    }
}
