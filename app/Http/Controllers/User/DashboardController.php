<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $page_title = "Dashboard";
        $user_id = auth()->user()->id;


        $user_service_info = UserRequest::where('user_id', $user_id)->paginate();
        $total_booking = UserRequest::where('user_id', $user_id)->whereIn('status', [1, 4, 5, 6])->count();

        return view('user.dashboard', compact(
            "page_title",
            'user_service_info',
            'total_booking'

        ));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login');
    }
}
