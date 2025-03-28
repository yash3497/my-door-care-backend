<?php

namespace App\Http\Controllers\Api\V1\Nanny;

use App\Models\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class DashboardController extends Controller
{
    function dashboard()
    {
        $nanny_id = auth()->user()->id;
        $user_request = UserRequest::with('nanny')->where('nanny_id', $nanny_id)->get()->map(function ($data) {
            return [
                'user_request' => $data,
                'nanny_profession' => $data->nanny->nannyProfession
            ];
        });
        $data = [
            'user_request' => $user_request,
        ];

        $message = ['success' => [__('Nanny Dashboard')]];
        return ApiResponse::success($message, $data);
    }

    function singleService($id)
    {
        $single_service = UserRequest::findOrFail($id);
        $data = [
            'single_service' => $single_service,
        ];
        $message = ['success' => [__('Single Service')]];
        return ApiResponse::success($message, $data);
    }
}
