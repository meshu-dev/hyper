<?php

namespace App\Transformers\Notion;

use App\Actions\Code\CodeToHtmlAction;
use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Block;

class NotionCodeTransformer implements NotionTransformer
{
    public function __construct(protected Block $block)
    {
    }

    public function transform(): string
    {
        $language = $this->block->getRawResponse()['code']['language'];
        $code     = $this->block->getRawContent()['text'][0]['plain_text'];

        $codeHtml = resolve(CodeToHtmlAction::class)->execute($language, $code);

        return view('code-block', ['codeBlock'  => $codeHtml])->render();
    }
}
