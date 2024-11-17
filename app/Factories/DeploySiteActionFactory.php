<?php

namespace App\Factories;

use App\Actions\Site\DevPush\DeploySiteAction as DeployDevPushSiteAction;
use App\Actions\Site\DevNudge\DeploySiteAction as DeployDevNudgeSiteAction;
use App\Enums\SiteEnum;

class DeploySiteActionFactory
{
    public function make(SiteEnum $site)
    {
        return match ($site) {
            SiteEnum::DEV_PUSH  => resolve(DeployDevPushSiteAction::class),
            SiteEnum::DEV_NUDGE => resolve(DeployDevNudgeSiteAction::class),
        };
    }
}
