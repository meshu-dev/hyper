<?php

namespace App\Actions\Subscriber;

use App\Models\Subscriber;

class RegisterAction
{
    public function execute(array $params)
    {
        return Subscriber::create([
            'name'  => $params['name'],
            'email' => $params['email']
        ]);
    }
}
