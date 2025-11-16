<?php

namespace App\Http\Controllers;

use App\Actions\Newsletter\SignUpAction;
use App\Http\Requests\SignUpRequest;
use Illuminate\Http\JsonResponse;

class NewsletterController extends Controller
{
    /**
     * Get all tags
     */
    public function signUp(SignUpRequest $request): JsonResponse
    {
        resolve(SignUpAction::class)->execute(
            $request->input('name'),
            $request->input('email'),
            $request->ip(),
        );

        return response()->json();
    }
}
