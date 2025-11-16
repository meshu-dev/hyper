<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;

class LoginAction
{
    private const string TOKEN_KEY = 'auth';

    public function execute(string $email, string $password): string|null
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return Auth::user()
                ?->createToken(self::TOKEN_KEY)
                ?->plainTextToken;
        }
        return null;
    }
}
