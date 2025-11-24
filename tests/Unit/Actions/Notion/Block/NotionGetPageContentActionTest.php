<?php

use App\Actions\Notion\Block\NotionGetPageBlocksAction;
use App\Actions\Notion\Block\NotionGetPageContentAction;
use FiveamCode\LaravelNotionApi\Entities\Blocks\{
    HeadingOne,
    Paragraph,
};
use FiveamCode\LaravelNotionApi\Entities\Page;
use Mockery\MockInterface;

describe('Actions - NotionGetPageContentAction', function () {
    it('gets the page content as HTML', function () {
        // Arrange
        $page = resolve(
            Page::class,
            [
                'responseData' => [
                    'object' => 'page',
                    'id' => Str::uuid(),
                ],
            ],
        );

        $h1Value = getTestData('h1');
        $h1Block = HeadingOne::create($h1Value);
        $h1Block->setContent($h1Value);

        $pValue = getTestData('p');
        $paragraphBlock = Paragraph::create($pValue);
        $paragraphBlock->setContent($pValue);

        $blocks = [
            $h1Block,
            $paragraphBlock,
        ];

        $getPageBlocksAction = mock(NotionGetPageBlocksAction::class, function (MockInterface $mock) use ($blocks) {
            $mock->shouldReceive('execute')
                ->once()
                ->andReturn($blocks);
        });

        // Act
        $result = resolve(NotionGetPageContentAction::class, ['getPageBlocksAction' => $getPageBlocksAction])->execute($page);

        // Assert
        expect($result)->toBe("<h1>$h1Value</h1><p>$pValue</p>");
    });
});
