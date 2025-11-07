<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class LoginAction
{
    private const string TOKEN_KEY = 'auth';

    public function execute(string $email, string $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $token = Auth::user()->createToken(self::TOKEN_KEY);

            return $token->plainTextToken;
        }
    }
}
