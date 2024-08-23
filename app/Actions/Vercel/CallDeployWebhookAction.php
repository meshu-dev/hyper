<?php

namespace App\Actions\Vercel;

use Illuminate\Support\Facades\Http;

class CallDeployWebhookAction
{
    public function execute(): bool
    {
        $vercelDeployWebhook = config('app.vercel_deploy_webhook');
        $response            = Http::post($vercelDeployWebhook);

        return $response->successful();
    }
}


