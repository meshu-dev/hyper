<?php

namespace App\Http\Controllers;

use App\Actions\Subscriber\RegisterAction;

class SubscriberController extends Controller
{
    /**
     * Get all tags
     */
    public function register(SubscriberRegisterRequest $request, RegisterAction $registerAction)
    {
        $row = $registerAction->execute();

        $isSuccess = $row ? true : false;

        return response()->json([
            'success' => $isSuccess,
            'message' => 'Thank you for subscribing'
        ]);
    }
}
