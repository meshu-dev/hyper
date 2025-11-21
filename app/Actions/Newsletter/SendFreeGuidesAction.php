<?php

namespace App\Actions\Newsletter;

use App\Mail\FreeGuides;
use App\Mail\NewsletterSubscribed;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SendFreeGuidesAction
{
    public function execute(int $subscriberId): void
    {
        $subscriber = Subscriber::find($subscriberId);

        Mail::to($subscriber->email)
            ->send(new FreeGuides($subscriber->name));

        $subscriber->sent = true;
        $subscriber->save();

        $this->sendNotification($subscriber);
    }

    protected function sendNotification(Subscriber $subscriber)
    {
        $notifyEmail = config('mail.from.notify.address');

        Mail::to($notifyEmail)
            ->send(new NewsletterSubscribed(
                $subscriber->name,
                $subscriber->email
            ));
    }
}
