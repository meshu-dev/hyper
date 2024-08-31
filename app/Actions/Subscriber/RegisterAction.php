<?php

namespace App\Actions\Subscriber;

use App\Exceptions\GoogleTokenException;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RegisterAction
{
    public function execute(array $params): Subscriber|null
    {
        $token           = $params['token'];
        $googleVerifyUrl = config('services.google.recaptcha.verify_url');
        $googleSecretKey = config('services.google.recaptcha.secret_key');

        $response = Http::asForm()->post(
            $googleVerifyUrl,
            [
                'secret'   => $googleSecretKey,
                'response' => $token
            ]
        );

        Log::error($response->body());

        $response = json_decode($response->body(), true);

        throw_unless(
            $response['success'],
            GoogleTokenException::class,
            $this->getErrorCode($response)
        );

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

    public function getErrorCode(array $response): string
    {
        if (!empty($response['error-codes'])) {
            $code = $response['error-codes'][0];
        } else {
            $code = 'default';
        }
        return $code;
    }
}
