<?php

namespace App\Actions\Newsletter;

use App\Mail\FreeGuides;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;

class SendFreeGuidesAction
{
    public function execute()
    {
        $sendCount = 0;
        
        $subscribers = Subscriber::where('sent', 0)->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)
                ->send(new FreeGuides($subscriber->name));

            $subscriber->sent = true;
            $subscriber->save();

            $sendCount++;
        }

        return $sendCount;
    }
}
