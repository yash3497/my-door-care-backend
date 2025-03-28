<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Constants\PaymentGatewayConst;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Http\Helpers\Api\Helpers as ApiResponse;
use Exception;

class ServiceTrakingController extends Controller
{
    function index()
    {
        $user_id = auth()->user()->id;

        $user_requests = UserRequest::with('nanny')->latest()->where('user_id', $user_id)
            ->whereIn('status', [0, 1, 4, 5, 6])
            ->get()->map(function ($item) {
                return [
                    'user_request' => $item,
                    'nanny_profession' => $item->nanny->nannyProfession,

                ];
            });


        $payment_gateways_currencies = PaymentGatewayCurrency::with('gateway')->whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::add_money_slug());
            $gateway->where('type', PaymentGatewayConst::AUTOMATIC);
            $gateway->where('status', 1);
        })->get()->map(function ($item) {
            return [
                'name' => $item->name,
                'alias' => $item->alias,
                'currency_code' => $item->currency_code,
                'currency_symbol' => $item->currency_symbol,
                'image' => $item->imageLink,
                'min_limit' => $item->min_limit,
                'max_limit' => $item->max_limit,
                'percent_charge' => $item->percent_charge,
                'fixed_charge' => $item->fixed_charge,
                'rate' => $item->rate,
                'gateway_image' => $item->gateway->image

            ];
        });


        $data = [
            'base_url' => url(''),
            'default_image' => "public/backend/images/default/profile-default.webp",
            "image_path"    => "public/backend/images/payment-gateways",
            'user_requests' => $user_requests,
            'payment_gateway' => $payment_gateways_currencies,
        ];
        $message = ['success' => [__('service tracking and payment gateway')]];
        return ApiResponse::success($message, $data);
    }
    function cancel(Request $request)
    {
        $id = $request->id;
        $service_request = UserRequest::findOrFail($id);
        try {
            $service_request->delete();
        } catch (Exception $e) {
            $error = ['error' => [__('something went wrong. Please try again')]];
            return ApiResponse::error($error);
        }

        $message = ['success' => [__('Service successfully cancel')]];
        return ApiResponse::onlysuccess($message);
    }
}
