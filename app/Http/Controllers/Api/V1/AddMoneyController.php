<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\UserWallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TemporaryData;
use App\Models\Admin\Currency;
use App\Http\Helpers\Api\Helpers;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\BasicSettings;
use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use App\Traits\PaymentGateway\Manual;
use App\Traits\PaymentGateway\Stripe;
use App\Constants\PaymentGatewayConst;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Api\PaymentGatewayApi;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Http\Helpers\Api\Helpers as ApiResponse;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use App\Http\Helpers\PaymentGateway as PaymentGatewayHelper;

class AddMoneyController extends Controller
{
    use Stripe, Manual;
    /**
     * Add Money History
     *
     * @method GET
     * @return \Illuminate\Http\Response
     */
    public function addMoneyInformation()
    {
        $user = auth()->user();
        $userWallet = UserWallet::where('user_id', $user->id)->get()->map(function ($data) {
            return [
                'balance' => getAmount($data->balance, 2),
                'currency' => get_default_currency_code(),
            ];
        })->first();
        $transactions = Transaction::auth()->addMoney()->latest('id')->get()->map(function ($item) {
            $statusInfo = [
                "success"  => 1,
                "pending"  => 2,
                "hold"     => 3,
                "rejected" => 4,
            ];

            return [
                'id'               => $item->id,
                'trx'              => $item->trx_id,
                'gateway_name'     => $item->currency->name,
                'transactin_type'  => $item->type,
                'request_amount'   => getAmount($item->request_amount, 2) . ' ' . get_default_currency_code(),
                'payable'          => getAmount($item->payable, 2) . ' ' . $item->user_wallet->currency->code,
                'exchange_rate'    => '1 ' . get_default_currency_code() . ' = ' . getAmount($item->currency->rate, 2) . ' ' . $item->currency->currency_code,
                'total_charge'     => getAmount($item->charge->total_charge, 2) . ' ' . $item->user_wallet->currency->code,
                'current_balance'  => getAmount($item->available_balance, 2) . ' ' . get_default_currency_code(),
                'status'           => $item->stringStatus->value,
                'date_time'        => $item->created_at,
                'status_info'      => (object)$statusInfo,
                'rejection_reason' => $item->reject_reason ?? "",
            ];
        });
        $gateways = PaymentGateway::where('status', 1)->where('slug', PaymentGatewayConst::add_money_slug())->get()->map(function ($gateway) {
            $currencies = PaymentGatewayCurrency::where('payment_gateway_id', $gateway->id)->get()->map(function ($data) {
                return [
                    'id'                 => $data->id,
                    'payment_gateway_id' => $data->payment_gateway_id,
                    'type'               => $data->gateway->type,
                    'name'               => $data->name,
                    'alias'              => $data->alias,
                    'currency_code'      => $data->currency_code,
                    'currency_symbol'    => $data->currency_symbol,
                    'image'              => $data->image,
                    'min_limit'          => getAmount($data->min_limit, 2),
                    'max_limit'          => getAmount($data->max_limit, 2),
                    'percent_charge'     => getAmount($data->percent_charge, 2),
                    'fixed_charge'       => getAmount($data->fixed_charge, 2),
                    'rate'               => getAmount($data->rate, 2),
                    'created_at'         => $data->created_at,
                    'updated_at'         => $data->updated_at,
                ];
            });

            return [
                'id'                   => $gateway->id,
                'image'                => $gateway->image,
                'slug'                 => $gateway->slug,
                'code'                 => $gateway->code,
                'type'                 => $gateway->type,
                'alias'                => $gateway->alias,
                'supported_currencies' => $gateway->supported_currencies,
                'status'               => $gateway->status,
                'currencies'           => $currencies
            ];
        });
        $user_wallet = UserWallet::where('user_id', Auth::id())->first();
        $top_history = [
            'balance' => get_amount($user_wallet->balance),

        ];
        $data = [
            'base_curr'      => get_default_currency_code(),
            'base_curr_rate' => getAmount(1, 2),
            'default_image'  => "public/backend/images/default/default.webp",
            "image_path"     => "public/backend/images/payment-gateways",
            'userWallet'     => (object)$userWallet,
            'gateways'       => $gateways,
            'transactions'   => $transactions,
            'top_history'    => $top_history,
        ];
        $message =  ['success' => [__('Payment Information!')]];
        return ApiResponse::success($message, $data);
    }

    /**
     * Add Money Form Submit
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency'  => "required",
            'amount'        => "required|numeric",
            'user_request_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            $error =  ['error' => $validator->errors()->all()];
            return ApiResponse::validation($error);
        }
        $basic_setting = BasicSettings::first();
        $user = auth()->user();

        $alias = $request->currency;
        $amount = $request->amount;
        $payment_gateways_currencies = PaymentGatewayCurrency::where('alias', $alias)->whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::add_money_slug());
            $gateway->where('status', 1);
        })->first();


        if (!$payment_gateways_currencies) {
            $error = ['error' => [__('Gateway Information is not available. Please provide payment gateway currency alias')]];
            return ApiResponse::error($error);
        }
        $defualt_currency = Currency::default();

        try {
            // $instance = PaymentGatewayHelper::init($request->all())->type(PaymentGatewayConst::TYPEADDMONEY)->gateway()->api()->get();
            $instance = PaymentGatewayApi::init($request->all())->type(PaymentGatewayConst::TYPEADDMONEY)->gateway()->api()->get();
            $trx = $instance['response']['id'] ?? $instance['response']['trx'] ?? $instance['response']['reference_id'] ?? $instance['response']['order_id'] ?? $instance['response']['tokenValue'] ?? $instance['response']['url'] ?? $instance['response']['temp_identifier'] ?? '';
            $temData = TemporaryData::where('identifier', $trx)->first();
            if (!$temData) {
                $error = ['error' => [__("Invalid Request")]];
                return ApiResponse::error($error);
            }
            $payment_gateway_currency = PaymentGatewayCurrency::where('id', $temData->data->currency)->first();
            $payment_gateway = PaymentGateway::where('id', $temData->data->gateway)->first();
            if ($payment_gateway->type == "AUTOMATIC") {
                if ($temData->type == PaymentGatewayConst::STRIPE) {
                    $payment_informations = [
                        'trx' =>  $temData->identifier,
                        'gateway_currency_name' =>  $payment_gateway_currency->name,
                        'request_amount' => getAmount($temData->data->amount->requested_amount, 4) . ' ' . $temData->data->amount->default_currency,
                        'exchange_rate' => "1" . ' ' . $temData->data->amount->default_currency . ' = ' . getAmount($temData->data->amount->sender_cur_rate, 4) . ' ' . $temData->data->amount->sender_cur_code,
                        'total_charge' => getAmount($temData->data->amount->total_charge, 4) . ' ' . $temData->data->amount->sender_cur_code,
                        'payable_amount' =>  getAmount($temData->data->amount->total_amount, 4) . ' ' . $temData->data->amount->sender_cur_code,
                    ];
                    $data = [
                        'gateway_type' => $payment_gateway->type,
                        'gateway_currency_name' => $payment_gateway_currency->name,
                        'alias' => $payment_gateway_currency->alias,
                        'identify' => $temData->type,
                        'payment_informations' => $payment_informations,
                        'url' => @$temData->data->response->link . "?prefilled_email=" . @$user->email,
                        'method' => "get",
                    ];
                    $message =  ['success' => [__('Payment Successfully')]];
                    return Helpers::success($message, $data);
                }else if($temData->type == PaymentGatewayConst::PAYSTACK) {

                    $payment_informations =[
                        'trx' =>  $temData->identifier,
                        'gateway_currency_name' =>  $payment_gateway_currency->name,
                        'request_amount' => get_amount($temData->data->amount->requested_amount,$temData->data->amount->default_currency,4),
                        'exchange_rate' => "1".' '.$temData->data->amount->default_currency.' = '.get_amount($temData->data->amount->sender_cur_rate,$temData->data->amount->sender_cur_code,4),
                        'total_charge' => get_amount($temData->data->amount->total_charge,$temData->data->amount->sender_cur_code,4),
                        'payable_amount' =>  get_amount($temData->data->amount->total_amount,$temData->data->amount->sender_cur_code,4),
                    ];

                    $data =[
                        'gateway_type' => $payment_gateway->type,
                        'gateway_currency_name' => $payment_gateway_currency->name,
                        'alias' => $payment_gateway_currency->alias,
                        'identify' => $temData->type,
                        'payment_informations' => $payment_informations,
                        'url' => $instance['response']['redirect_url'],
                        'method' => "get",
                    ];
                    $message =  ['success'=>[__('Payment Successfully')]];
                    return ApiResponse::success($message, $data);
                } elseif ($temData->type == PaymentGatewayConst::SSLCOMMERZ) {

                    $payment_informations = [
                        'trx' =>  $temData->identifier,
                        'gateway_currency_name' =>  $payment_gateway_currency->name,
                        'request_amount' => getAmount($temData->data->amount->requested_amount, 4) . ' ' . $temData->data->amount->default_currency,
                        'exchange_rate' => "1" . ' ' . $temData->data->amount->default_currency . ' = ' . getAmount($temData->data->amount->sender_cur_rate, 4) . ' ' . $temData->data->amount->sender_cur_code,
                        'total_charge' => getAmount($temData->data->amount->total_charge, 4) . ' ' . $temData->data->amount->sender_cur_code,
                        'payable_amount' =>  getAmount($temData->data->amount->total_amount, 4) . ' ' . $temData->data->amount->sender_cur_code,
                    ];
                    $data = [
                        'gateway_type' => $payment_gateway->type,
                        'gateway_currency_name' => $payment_gateway_currency->name,
                        'alias' => $payment_gateway_currency->alias,
                        'identify' => $temData->type,
                        'payment_informations' => $payment_informations,
                        'url' => $instance['response']['link'],
                        'method' => "get",
                    ];
                    $message =  ['success' => ['Payment Successfully']];
                    return Helpers::success($message, $data);
                } else if ($temData->type == PaymentGatewayConst::PAYPAL) {

                    $payment_informations = [
                        'trx' =>  $temData->identifier,
                        'gateway_currency_name' =>  $payment_gateway_currency->name,
                        'request_amount' => getAmount($temData->data->amount->requested_amount, 4) . ' ' . $temData->data->amount->default_currency,
                        'exchange_rate' => "1" . ' ' . $temData->data->amount->default_currency . ' = ' . getAmount($temData->data->amount->sender_cur_rate) . ' ' . $temData->data->amount->sender_cur_code,
                        'total_charge' => getAmount($temData->data->amount->total_charge, 2) . ' ' . $temData->data->amount->sender_cur_code,
                        // 'will_get' => getAmount($temData->data->amount->will_get, 2) . ' ' . $temData->data->amount->default_currency,
                        'payable_amount' =>  getAmount($temData->data->amount->total_amount, 2) . ' ' . $temData->data->amount->sender_cur_code,
                    ];
                    $data = [
                        'gategay_type' => $payment_gateway->type,
                        'gateway_currency_name' => $payment_gateway_currency->name,
                        'alias' => $payment_gateway_currency->alias,
                        'identify' => $temData->type,
                        'payment_informations' => $payment_informations,
                        'url' => @$temData->data->response->links,
                        'method' => "get",
                    ];
                    $message =  ['success' => [__('Payment Successfully')]];
                    return Helpers::success($message, $data);
                } else if ($temData->type == PaymentGatewayConst::FLUTTER_WAVE) {
                    $payment_informations = [
                        'trx' =>  $temData->identifier,
                        'gateway_currency_name' =>  $payment_gateway_currency->name,
                        'request_amount' => getAmount($temData->data->amount->requested_amount, 4) . ' ' . $temData->data->amount->default_currency,
                        'exchange_rate' => "1" . ' ' . $temData->data->amount->default_currency . ' = ' . getAmount($temData->data->amount->sender_cur_rate, 4) . ' ' . $temData->data->amount->sender_cur_code,
                        'total_charge' => getAmount($temData->data->amount->total_charge, 4) . ' ' . $temData->data->amount->sender_cur_code,
                        'payable_amount' =>  getAmount($temData->data->amount->total_amount, 4) . ' ' . $temData->data->amount->sender_cur_code,
                    ];
                    $data = [
                        'gateway_type' => $payment_gateway->type,
                        'gateway_currency_name' => $payment_gateway_currency->name,
                        'alias' => $payment_gateway_currency->alias,
                        'identify' => $temData->type,
                        'payment_informations' => $payment_informations,
                        'url' => @$temData->data->response->link,
                        'method' => "get",
                    ];
                    $message =  ['success' => [__('Payment Successfully')]];
                    return Helpers::success($message, $data);
                } else if ($temData->type == PaymentGatewayConst::RAZORPAY) {
                    $payment_informations = [

                        'trx' =>  $temData->identifier,
                        'gateway_currency_name' =>  $payment_gateway_currency->name,
                        'request_amount' => getAmount($temData->data->amount->requested_amount, 4) . ' ' . $temData->data->amount->default_currency,
                        'exchange_rate' => "1" . ' ' . $temData->data->amount->default_currency . ' = ' . getAmount($temData->data->amount->sender_cur_rate, 4) . ' ' . $temData->data->amount->sender_cur_code,
                        'total_charge' => getAmount($temData->data->amount->total_charge, 4) . ' ' . $temData->data->amount->sender_cur_code,
                        // 'will_get' => getAmount($temData->data->amount->will_get, 4) . ' ' . $temData->data->amount->default_currency,
                        'payable_amount' =>  getAmount($temData->data->amount->total_amount, 4) . ' ' . $temData->data->amount->sender_cur_code,
                    ];
                    $data = [
                        'gateway_type' => $payment_gateway->type,
                        'gateway_currency_name' => $payment_gateway_currency->name,
                        'alias' => $payment_gateway_currency->alias,
                        'identify' => $temData->type,
                        'payment_informations' => $payment_informations,
                        'url' => $instance['response']['redirect_url'],
                        'method' => "get",
                    ];
                    $message =  ['success' => [__('Payment Successfully')]];
                    return Helpers::success($message, $data);
                } else if ($temData->type == PaymentGatewayConst::QRPAY) {
                    $payment_informations = [

                        'trx' =>  $temData->identifier,
                        'gateway_currency_name' =>  $payment_gateway_currency->name,
                        'request_amount' => getAmount($temData->data->amount->requested_amount, 4) . ' ' . $temData->data->amount->default_currency,
                        'exchange_rate' => "1" . ' ' . $temData->data->amount->default_currency . ' = ' . getAmount($temData->data->amount->sender_cur_rate, 4) . ' ' . $temData->data->amount->sender_cur_code,
                        'total_charge' => getAmount($temData->data->amount->total_charge, 4) . ' ' . $temData->data->amount->sender_cur_code,
                        // 'will_get' => getAmount($temData->data->amount->will_get, 4) . ' ' . $temData->data->amount->default_currency,
                        'payable_amount' =>  getAmount($temData->data->amount->total_amount, 4) . ' ' . $temData->data->amount->sender_cur_code,
                    ];
                    $data = [
                        'gateway_type' => $payment_gateway->type,
                        'gateway_currency_name' => $payment_gateway_currency->name,
                        'alias' => $payment_gateway_currency->alias,
                        'identify' => $temData->type,
                        'payment_informations' => $payment_informations,
                        'url' => @$instance['response']['link'],
                        'method' => "get",
                    ];
                    $message =  ['success' => [__('Payment Successfully')]];
                    return Helpers::success($message, $data);
                }
            } elseif ($payment_gateway->type == "MANUAL") {

                $payment_informations = [
                    'trx' =>  $temData->identifier,
                    'gateway_currency_name' =>  $payment_gateway_currency->name,
                    'request_amount' => getAmount($temData->data->amount->requested_amount, 2) . ' ' . $temData->data->amount->default_currency,
                    'exchange_rate' => "1" . ' ' . $temData->data->amount->default_currency . ' = ' . getAmount($temData->data->amount->sender_cur_rate) . ' ' . $temData->data->amount->sender_cur_code,
                    'total_charge' => getAmount($temData->data->amount->total_charge, 2) . ' ' . $temData->data->amount->sender_cur_code,
                    'will_get' => getAmount($temData->data->amount->will_get, 2) . ' ' . $temData->data->amount->default_currency,
                    'payable_amount' =>  getAmount($temData->data->amount->total_amount, 2) . ' ' . $temData->data->amount->sender_cur_code,
                ];
                $data = [
                    'gategay_type' => $payment_gateway->type,
                    'gateway_currency_name' => $payment_gateway_currency->name,
                    'alias' => $payment_gateway_currency->alias,
                    'identify' => $temData->type,
                    'details' => $payment_gateway->desc ?? null,
                    'input_fields' => $payment_gateway->input_fields ?? null,
                    'payment_informations' => $payment_informations,
                    'url' => route('api.v1.user.add-money.manual.payment.confirmed'),
                    'method' => "post",
                ];
                $message =  ['success' => [__('Payment Successfully')]];
                return ApiResponse::success($message, $data);
            } else {
                $error = ['error' => [__("Something is wrong")]];
                return ApiResponse::error($error);
            }
        } catch (Exception $e) {
            $error = ['error' => [$e->getMessage()]];
            return ApiResponse::error($error);
        }
    }

    public function success(Request $request, $gateway)
    {
        $requestData = $request->all();
        $token = $requestData['token'] ?? "";
        $checkTempData = TemporaryData::where("type", $gateway)->where("identifier", $token)->first();
        if (!$checkTempData) {
            $message = ['error' => [__("Transaction failed. Record didn\'t saved properly. Please try again.")]];
            return ApiResponse::error($message);
        }

        $checkTempData = $checkTempData->toArray();

        try {
            PaymentGatewayApi::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive();
        } catch (Exception $e) {
            $message = ['error' => [$e->getMessage()]];
            return ApiResponse::error($message);
        }
        $message = ['success' => [__("Payment successful, please go back your app")]];
        return ApiResponse::onlysuccess($message);
    }

    public function cancel(Request $request, $gateway)
    {
        $message = ['error' => [__("Something is worng")]];
        return ApiResponse::error($message);
    }
    //stripe success
    public function stripePaymentSuccess($trx)
    {
        $token = $trx;
        $checkTempData = TemporaryData::where("type", PaymentGatewayConst::STRIPE)->where("identifier", $token)->first();
        $message = ['error' => [__('Transaction Failed. Record didn\'t saved properly. Please try again.')]];

        if (!$checkTempData) return ApiResponse::error($message);
        $checkTempData = $checkTempData->toArray();

        try {
            PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceiveApi('stripe');
        } catch (Exception $e) {

            $message = ['error' => [__("Something Is Wrong...")]];
            ApiResponse::error($message);
        }
        $message = ['success' => [__("Payment Successful, Please Go Back Your App")]];
        return ApiResponse::onlysuccess($message);
    }
    //Fluttewave
    public function flutterwaveCallback()
    {

        $status = request()->status;

        if ($status ==  'successful') {

            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);

            $requestData = request()->tx_ref;

            $token = $requestData;

            $checkTempData = TemporaryData::where("type", 'flutterwave')->where("identifier", $token)->first();

            $message = ['error' => [__('Transaction Failed. Record didn\'t saved properly. Please try again.')]];

            if (!$checkTempData) return Helpers::error($message);

            $checkTempData = $checkTempData->toArray();
            try {
                PaymentGatewayApi::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive('flutterWave');
            } catch (Exception $e) {
                $message = ['error' => [$e->getMessage()]];
                return Helpers::error($message);
            }
            $message = ['success' => [__("Payment Successful, Please Go Back Your App")]];
            return Helpers::onlysuccess($message);
        } elseif ($status ==  'cancelled') {
            $message = ['error' => [__('Payment Cancelled')]];
            return  Helpers::error($message);
        } else {
            $message = ['error' => [__('Payment Failed')]];
            return Helpers::error($message);
        }
    }


    public function qrpayCancel(Request $request, $trx_id)
    {
        $checkTempData = TemporaryData::where("identifier", $trx_id)->delete();
        $message = ['error' => [__('Transaction Failed. Record didn\'t saved properly. Please try again.')]];
        return Helpers::error($message);
    }
    //sslcommerz success
    public function sllCommerzSuccess(Request $request)
    {
        $data = $request->all();
        $token = $data['tran_id'];
        $checkTempData = TemporaryData::where("type", PaymentGatewayConst::SSLCOMMERZ)->where("identifier", $token)->first();
        $message = ['error' => [__('Transaction Failed. Record didn\'t saved properly. Please try again.')]];
        if (!$checkTempData) return Helpers::error($message);
        $checkTempData = $checkTempData->toArray();

        $creator_table = $checkTempData['data']->creator_table ?? null;
        $creator_id = $checkTempData['data']->creator_id ?? null;
        $creator_guard = $checkTempData['data']->creator_guard ?? null;
        $api_authenticated_guards = PaymentGatewayConst::apiAuthenticateGuard();
        if ($creator_table != null && $creator_id != null && $creator_guard != null) {
            if (!array_key_exists($creator_guard, $api_authenticated_guards)) throw new Exception('Request user doesn\'t save properly. Please try again');
            $creator = DB::table($creator_table)->where("id", $creator_id)->first();
            if (!$creator) throw new Exception("Request user doesn\'t save properly. Please try again");
            $api_user_login_guard = $api_authenticated_guards[$creator_guard];
            Auth::guard($api_user_login_guard)->loginUsingId($creator->id);
        }
        if ($data['status'] != "VALID") {
            $message = ['error' => [__("Payment Failed")]];
            return Helpers::error($message);
        }
        try {
            PaymentGatewayApi::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive('sslcommerz');
        } catch (Exception $e) {
            $message = ['error' => [__("Something Is Wrong")]];
            return Helpers::error($message);
        }
        $message = ['success' => [__("Payment Successful, Please Go Back Your App")]];
        return Helpers::onlysuccess($message);
    }
    //sslCommerz fails
    public function sllCommerzFails(Request $request)
    {
        $data = $request->all();

        $token = $data['tran_id'];
        $checkTempData = TemporaryData::where("type", PaymentGatewayConst::SSLCOMMERZ)->where("identifier", $token)->first();
        $message = ['error' => [__('Transaction Failed. Record didn\'t saved properly. Please try again.')]];
        if (!$checkTempData) return Helpers::error($message);
        $checkTempData = $checkTempData->toArray();

        $creator_table = $checkTempData['data']->creator_table ?? null;
        $creator_id = $checkTempData['data']->creator_id ?? null;
        $creator_guard = $checkTempData['data']->creator_guard ?? null;

        $api_authenticated_guards = PaymentGatewayConst::apiAuthenticateGuard();
        if ($creator_table != null && $creator_id != null && $creator_guard != null) {
            if (!array_key_exists($creator_guard, $api_authenticated_guards)) throw new Exception('Request user doesn\'t save properly. Please try again');
            $creator = DB::table($creator_table)->where("id", $creator_id)->first();
            if (!$creator) throw new Exception("Request user doesn\'t save properly. Please try again");
            $api_user_login_guard = $api_authenticated_guards[$creator_guard];
            Auth::guard($api_user_login_guard)->loginUsingId($creator->id);
        }
        if ($data['status'] == "FAILED") {
            TemporaryData::destroy($checkTempData['id']);
            $message = ['error' => [__("Payment Money Failed")]];
            return Helpers::error($message);
        }
    }
    //sslCommerz canceled
    public function sllCommerzCancel(Request $request)
    {
        $data = $request->all();
        $token = $data['tran_id'];
        $checkTempData = TemporaryData::where("type", PaymentGatewayConst::SSLCOMMERZ)->where("identifier", $token)->first();
        $message = ['error' => [__('Transaction Failed. Record didn\'t saved properly. Please try again.')]];
        if (!$checkTempData) return Helpers::error($message);
        $checkTempData = $checkTempData->toArray();


        $creator_table = $checkTempData['data']->creator_table ?? null;
        $creator_id = $checkTempData['data']->creator_id ?? null;
        $creator_guard = $checkTempData['data']->creator_guard ?? null;

        $api_authenticated_guards = PaymentGatewayConst::apiAuthenticateGuard();
        if ($creator_table != null && $creator_id != null && $creator_guard != null) {
            if (!array_key_exists($creator_guard, $api_authenticated_guards)) throw new Exception('Request user doesn\'t save properly. Please try again');
            $creator = DB::table($creator_table)->where("id", $creator_id)->first();
            if (!$creator) throw new Exception("Request user doesn\'t save properly. Please try again");
            $api_user_login_guard = $api_authenticated_guards[$creator_guard];
            Auth::guard($api_user_login_guard)->loginUsingId($creator->id);
        }
        if ($data['status'] != "VALID") {
            TemporaryData::destroy($checkTempData['id']);
            $message = ['error' => [__("Payment Canceled")]];
            return Helpers::error($message);
        }
    }

    public function redirectBtnPay(Request $request, $gateway)
    {
        try {
            return PaymentGatewayApi::init([])->type('ADD-MONEY')->handleBtnPay($gateway, $request->all());
        } catch (Exception $e) {
            $message = ['error' => [$e->getMessage()]];
            return Helpers::error($message);
        }
    }
    public function successGlobal(Request $request, $gateway)
    {
        try {
            $token = PaymentGatewayApi::getToken($request->all(), $gateway);
            $temp_data = TemporaryData::where("identifier", $token)->first();

            if (!$temp_data) {
                if (Transaction::where('callback_ref', $token)->exists()) {
                    $message = ['error' => [__('Transaction request sended successfully!')]];
                    return Helpers::error($message);
                } else {
                    $message = ['error' => [__('Transaction failed. Record didn\'t saved properly. Please try again')]];
                    return Helpers::error($message);
                }
            }

            $update_temp_data = json_decode(json_encode($temp_data->data), true);
            $update_temp_data['callback_data']  = $request->all();
            $temp_data->update([
                'data'  => $update_temp_data,
            ]);
            $temp_data = $temp_data->toArray();
            $instance = PaymentGatewayApi::init($temp_data)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive($temp_data['type']);

            // return $instance;
        } catch (Exception $e) {
            $message = ['error' => [$e->getMessage()]];
            return Helpers::error($message);
        }
        $message = ['success' => [__('Payment Successfully.')]];
        return Helpers::onlysuccess($message);
    }
    public function cancelGlobal(Request $request, $gateway)
    {
        $token = PaymentGatewayApi::getToken($request->all(), $gateway);
        $temp_data = TemporaryData::where("identifier", $token)->first();
        try {
            if ($temp_data != null) {
                $temp_data->delete();
            }
        } catch (Exception $e) {
            // Handel error
        }
        $message = ['success' => [__('Payment Canceled Successfully')]];
        return Helpers::error($message);
    }

    public function postSuccess(Request $request, $gateway)
    {
        try {
            $token = PaymentGatewayApi::getToken($request->all(), $gateway);
            $temp_data = TemporaryData::where("identifier", $token)->first();
            if ($temp_data && $temp_data->data->creator_guard != 'api') {
                Auth::guard($temp_data->data->creator_guard)->loginUsingId($temp_data->data->creator_id);
            }
        } catch (Exception $e) {
            $message = ['error' => [$e->getMessage()]];
            return Helpers::error($message);
        }

        return $this->successGlobal($request, $gateway);
    }

    public function postCancel(Request $request, $gateway)
    {
        try {
            $token = PaymentGatewayApi::getToken($request->all(), $gateway);
            $temp_data = TemporaryData::where("identifier", $token)->first();
            if ($temp_data && $temp_data->data->creator_guard != 'api') {
                Auth::guard($temp_data->data->creator_guard)->loginUsingId($temp_data->data->creator_id);
            }
        } catch (Exception $e) {
            $message = ['error' => [$e->getMessage()]];
            return Helpers::error($message);
        }

        return $this->cancelGlobal($request, $gateway);
    }
}
