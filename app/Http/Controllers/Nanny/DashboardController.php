<?php

namespace App\Http\Controllers\Nanny;

use App\Http\Controllers\Controller;
use App\Models\Admin\Currency;
use App\Models\NannyWallet;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function index()
    {

        $nanny_id = auth()->user()->id;
        $user_request = UserRequest::where('nanny_id', $nanny_id)->paginate(3);
        $nanny_wallet = NannyWallet::where('nanny_id', $nanny_id)->first();
        $base_currency = Currency::first();

        return view('nanny.dashboard', compact('user_request', 'nanny_wallet', 'base_currency'));
    }
    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('nanny.login');
    }
}
