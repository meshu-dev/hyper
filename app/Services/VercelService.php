<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VercelService
{
    public function callDeployHook($hookUrl): bool
    {
        $response = Http::post($hookUrl);
        return $response->successful();
    }
}
