<?php

namespace App\Http\Controllers\User;

use App\Models\UserRequest;
use Illuminate\Support\Str;
use App\Models\Admin\Currency;
use Illuminate\Support\Carbon;
use App\Models\NannyNotification;
use App\Constants\NotificationConst;
use App\Http\Controllers\Controller;
use App\Constants\PaymentGatewayConst;
use App\Models\Admin\PaymentGatewayCurrency;

class ServiceTrackingController extends Controller
{
    function index()
    {
        $user_id = auth()->user()->id;
        $user_requests = UserRequest::with('user')
            ->where('user_id', $user_id)
            ->whereIn('status', [0, 1, 4, 5, 6])
            ->latest()
            ->get();

        $payment_gateways_currencies = PaymentGatewayCurrency::with('gateway')->whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::add_money_slug());
            $gateway->where('type', PaymentGatewayConst::AUTOMATIC);
            $gateway->where('status', 1);
        })->get();

        $default_currency = Currency::default();


        return view('user.sections.service-tracking.index', compact('user_requests', 'payment_gateways_currencies', 'default_currency'));
    }
    function cancel($id)
    {
        $service_request = UserRequest::with('nanny')->findOrFail($id);
        $nanny_id = $service_request->nanny->id;
        //notification
        $notification_content = [
            'title'         => "Service Cancel",
            'message'       => auth()->user()->fullname . " have canceled service request",
            'time'          => Carbon::now()->diffForHumans(),
            'image'         => files_asset_path('profile-default'),
        ];
        NannyNotification::create([
            'type'      => NotificationConst::SERVICE_CANCEL,
            'nanny_id'  => $nanny_id,
            'message'   => $notification_content,
        ]);
        $service_request->delete();
        return back()->with(['success' => ['Service successfully deleted']]);
    }
}
