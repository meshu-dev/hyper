<?php

namespace App\Http\Controllers;

use App\Actions\Auth\LoginAction;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Login the user
     */
    public function login(LoginRequest $request, LoginAction $loginAction): JsonResponse
    {
        $token = $loginAction->execute($request->email, $request->password);

        $params = $token ? ['data' => ['token' => $token]] : ['error' => 'Login details are invalid'];
        $code   = $token ? Response::HTTP_OK : Response::HTTP_UNAUTHORIZED;

        return response()->json($params, $code);
    }
}
