<?php

namespace App\Http\Controllers;

use App\Actions\Subscriber\RegisterAction;
use App\Http\Requests\SubscriberRegisterRequest;

class SubscriberController extends Controller
{
    /**
     * Get all tags
     */
    public function register(SubscriberRegisterRequest $request, RegisterAction $registerAction, int $siteId)
    {
        $params = $request->all();
        $params['site_id'] = $siteId;

        $row = $registerAction->execute($params);

        $isSuccess = $row ? true : false;

        return response()->json([
            'success' => $isSuccess,
            'message' => 'Thank you for subscribing'
        ]);
    }
}
