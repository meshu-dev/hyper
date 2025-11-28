<?php

namespace App\Actions\Newsletter;

use App\Enums\UserEnum;
use App\Mail\FreeGuides;
use App\Models\{Subscriber, User};
use App\Notifications\GuidesSent;
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
        User::find(UserEnum::ADMIN)->notify(
            resolve(
                GuidesSent::class,
                ['subscriber' => $subscriber]
            )
        );
    }
}
