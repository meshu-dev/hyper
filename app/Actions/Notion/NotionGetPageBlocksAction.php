<?php

namespace App\Actions\Notion;

use App\Collections\BulletItemCollection;
use App\Collections\NumberedItemCollection;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Block;
use FiveamCode\LaravelNotionApi\Entities\Blocks\BulletedListItem;
use FiveamCode\LaravelNotionApi\Entities\Blocks\NumberedListItem;
use FiveamCode\LaravelNotionApi\Entities\Page;
use FiveamCode\LaravelNotionApi\Notion;
use Illuminate\Support\Collection;
use UnhandledMatchError;

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

    /**
     * @return array<int, mixed>
     */
    public function execute(Page $page): array
    {
        $pageBlocks = $this->notion
            ->block($page->getId())
            ->children()
            ->asCollection();

        $pageBlocksLength = count($pageBlocks);
        $pageItems = [];

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

    /**
     * @param Collection<int, Block> $pageBlocks
     * @return BulletItemCollection|NumberedItemCollection
     */
    protected function groupBulletItems(Collection $pageBlocks, int $index, string $type): BulletItemCollection|NumberedItemCollection
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
            default => throw new UnhandledMatchError(),
        };
    }
}
