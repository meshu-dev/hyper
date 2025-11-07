<?php

namespace App\Actions\Vercel;

use Illuminate\Support\Facades\Http;

class DeployWebhookAction
{
    public function execute(string $hookUrl): bool
    {
        $response = Http::post($hookUrl);

        return $response->successful();
    }
}
