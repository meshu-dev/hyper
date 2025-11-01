<?php

namespace App\Http\Controllers;

use App\Actions\Newsletter\SignUpAction;
use App\Http\Requests\SignUpRequest;

class NewsletterController extends Controller
{
    /**
     * Get all tags
     */
    public function signUp(SignUpRequest $request)
    {
        resolve(SignUpAction::class)->execute(
            $request->input('name'),
            $request->input('email'),
            $request->ip(),
        );

        return response()->json();
    }
}
