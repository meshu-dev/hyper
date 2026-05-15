<?php

namespace App\Actions\Code;

use Phiki\Adapters\Laravel\Facades\Phiki;
use Phiki\Grammar\Grammar;
use Phiki\Theme\Theme;
use UnhandledMatchError;

class CodeToHtmlAction
{
    public function execute(string $language, string $code): string
    {
        $html = Phiki::codeToHtml(
            $code,
            $this->getGrammar($language),
            Theme::GithubDark
        )->toString();
        
        return $html;
    }

    protected function getGrammar(string $language): Grammar
    {
        return match ($language) {
            'plain text' => Grammar::Txt,
            'bash'       => Grammar::SshConfig,
            'html'       => Grammar::Html,
            'css'        => Grammar::Css,
            'php'        => Grammar::Php,
            'javascript' => Grammar::Javascript,
            'typescript' => Grammar::Typescript,
            'sql'        => Grammar::Sql,
            default => throw new UnhandledMatchError(),
        };
    }
}
