<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Stripe\ApiResource;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class UserNotificationController extends Controller
{
    function index()
    {
        $user_notification = UserNotification::get();
        $data = [
            'user_notification' => $user_notification
        ];

        $message = ['success' => [__('User Notification')]];
        return ApiResponse::success($message, $data);
    }
}
