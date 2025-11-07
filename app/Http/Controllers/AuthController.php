<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginAction;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Login the user
     */
    public function login(LoginRequest $request, LoginAction $loginAction)
    {
        $token = $loginAction->execute($request->email, $request->password);
        return response()->json(['token' => $token]);
    }
}
