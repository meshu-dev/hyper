<?php

namespace App\Actions\Vercel;

use App\Enums\SiteEnum;
use Illuminate\Support\Facades\Http;

class DeployWebhookAction
{
    public function execute(SiteEnum $site): bool
    {
        $siteKey = $site->key();
        $hookUrl = config("services.vercel.$siteKey.deploy_hook");

        $response = Http::post($hookUrl);

        return $response->successful();
    }
}
