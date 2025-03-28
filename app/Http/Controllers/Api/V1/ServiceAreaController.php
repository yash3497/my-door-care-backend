<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Admin\ServiceArea;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class ServiceAreaController extends Controller
{
    function servicearea()
    {
        $service_areas = ServiceArea::get();
        $message = ['success' => ['All services area']];
        return ApiResponse::success($message, $service_areas);
    }
}
