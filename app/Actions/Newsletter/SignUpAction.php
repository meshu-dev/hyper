<?php

namespace App\Actions\Newsletter;

use App\Jobs\SendFreeGuidesJob;
use App\Models\Subscriber;

class SignUpAction
{
    public function execute(
        string $name,
        string $email,
        string|null $ip,
    ): void {
        $subscriber = Subscriber::create([
            'name' => $name,
            'email' => $email,
            'ip' => $ip,
            'sent' => false,
        ]);

        SendFreeGuidesJob::dispatch($subscriber->id);
    }
}
