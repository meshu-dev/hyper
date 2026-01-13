<?php

namespace App\Factories;

use App\Actions\YouTube\LinkBlogToVideoAction;
use App\Enums\SiteEnum;

class NotionImportPageSiteActionFactory
{
    public function make(SiteEnum $site): object
    {
        return match ($site::class) {
            SiteEnum::DEVPUSH => resolve(LinkBlogToVideoAction::class),
            default           => null,
        };
    }
}
