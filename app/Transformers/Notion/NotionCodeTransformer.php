<?php

namespace App\Transformers\Notion;

use App\Contracts\NotionTransformer;
use FiveamCode\LaravelNotionApi\Entities\Blocks\Block;
use UnhandledMatchError;

class NotionCodeTransformer implements NotionTransformer
{
    public function __construct(protected Block $block)
    {
    }

    public function transform(): string
    {
        $language = $this->block->getRawResponse()['code']['language'];
        $code = $this->block->getRawContent()['text'][0]['plain_text'];

        return "<pre><code class='".$this->getClass($language)."'>".
                    htmlspecialchars($code).
                '</code></pre>';
    }

    protected function getClass(string $language): string
    {
        return match ($language) {
            'plain text' => 'language-plaintext',
            'bash' => 'language-bash',
            'html' => 'language-html',
            'css' => 'language-css',
            'php' => 'language-php',
            'javascript' => 'language-javascript',
            'typescript' => 'language-typescript',
            'sql' => 'language-sql',
            default => throw new UnhandledMatchError(),
        };
    }
}
