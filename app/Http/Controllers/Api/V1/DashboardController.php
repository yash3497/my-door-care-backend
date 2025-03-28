<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class DashboardController extends Controller
{


    public function dashboard()
    {
        $page_title = "Dashboard";
        $user_id = auth()->user()->id;

        $user_service_info = UserRequest::where('user_id', $user_id)->paginate(2);
        $total_booking = UserRequest::where('status', 1)->whereIn('status', [4, 5, 6])->count();

        $data = [
            ''
        ];

        return view('user.dashboard', compact(
            "page_title",
            'user_service_info',
            'total_booking'

        ));
    }
}
