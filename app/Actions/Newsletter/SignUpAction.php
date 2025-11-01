<?php

namespace App\Actions\Newsletter;

use App\Mail\NewsletterSubscribed;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SignUpAction
{
    public function execute(
        string $name,
        string $email,
        string $ip,
    ) {
        Subscriber::create([
            'name'  => $name,
            'email' => $email,
            'ip'    => $ip,
            'sent'  => false,
        ]);

        $notifyEmail = config('mail.from.notify.address');

        Mail::to($notifyEmail)
            ->send(new NewsletterSubscribed(
                $name,
                $email
            ));
    }
}
