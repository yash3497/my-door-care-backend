<?php

namespace App\Http\Controllers\Api\V1\Nanny;

use App\Http\Controllers\Controller;
use App\Models\NannyNotification;
use Illuminate\Http\Request;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class NannyNotificationController extends Controller
{
    function index()
    {
        $nanny_notification = NannyNotification::get();
        $data = [
            'nanny_notification' => $nanny_notification
        ];

        $message = ['success' => [__('Nanny Notification')]];
        return ApiResponse::success($message, $data);
    }
}
