<?php

namespace App\Actions\Subscriber;

use App\Models\Subscriber;

class RegisterAction
{
    public function execute(array $params)
    {
        return Subscriber::create([
            'site_id' => $params['site_id'],
            'name'    => $params['name'],
            'email'   => $params['email']
        ]);
    }
}
