<?php

namespace App\Actions\Subscriber;

use App\Models\Subscriber;

class RegisterAction
{
    public function execute(array $params): Subscriber|null
    {
        $subscriber = Subscriber::where('email', $params['email'])->first();

        if (!$subscriber) {
            $subscriber = Subscriber::create([
                'site_id' => $params['site_id'],
                'email'   => $params['email'],
                'ip'      => $params['ip']
            ]);
        }
        return $subscriber;
    }
}
