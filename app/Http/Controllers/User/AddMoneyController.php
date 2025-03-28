<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\UserWallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TemporaryData;
use App\Http\Helpers\Response;
use App\Models\Admin\Currency;
use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use App\Traits\PaymentGateway\Manual;
use App\Traits\PaymentGateway\Stripe;
use Illuminate\Http\RedirectResponse;
use App\Constants\PaymentGatewayConst;
use Illuminate\Support\Facades\Session;
use App\Traits\PaymentGateway\QrpayTrait;
use App\Traits\PaymentGateway\RazorTrait;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Traits\PaymentGateway\SslcommerzTrait;
use KingFlamez\Rave\Facades\Rave as Flutterwave;
use App\Http\Helpers\PaymentGateway as PaymentGatewayHelper;

class AddMoneyController extends Controller
{
    use Stripe, Manual, RazorTrait, SslcommerzTrait, QrpayTrait;

    public function index()
    {
        $page_title = "Add Money";
        $user_wallets = UserWallet::auth()->get();

        $user_currencies = Currency::whereIn('id', $user_wallets->pluck('id')->toArray())->get();

        $payment_gateways_currencies = PaymentGatewayCurrency::whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::add_money_slug());
            $gateway->where('status', 1);
        })->get();

        $transactions = Transaction::auth()->addMoney()->latest()->take(3)->get();

        return view('user.sections.add-money.index', compact("page_title", "transactions", "payment_gateways_currencies"));
    }

    public function getCurrenciesXml(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'target'        => "required|integer|exists:payment_gateways,code",
        ]);
        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 400);
        }
        $validated = $validator->validate();

        $user_wallets = UserWallet::auth()->get();
        $user_currencies = Currency::whereIn('id', $user_wallets->pluck('currency_id')->toArray())->get();

        try {
            $payment_gateways = PaymentGateway::active()->gateway($validated['target'])->withWhereHas('currencies', function ($q) use ($user_currencies) {
                $q->whereIn("currency_code", $user_currencies->pluck("code")->toArray());
            })->has("currencies")->first();
        } catch (Exception $e) {
            $error = ['error' => ['Something went wrong!. Please try again.']];
            return Response::error($error, null, 500);
        }

        if (!$payment_gateways) {
            $error = ['error' => ['Opps! Invalid Payment Gateway']];
            return Response::error($error, null, 404);
        }

        $success = ['success' => ['Request server successfully']];
        return Response::success($success, $payment_gateways, 200);
    }

    public function submit(Request $request)
    {
        try {
            $instance = PaymentGatewayHelper::init($request->all())->type(PaymentGatewayConst::TYPEADDMONEY)->gateway()->render();
        } catch (Exception $e) {
            return back()->with(['error' => [$e->getMessage()]]);
        }
        return $instance;
    }

    public function success(Request $request, $gateway)
    {

        $requestData = $request->all();
        $token = $requestData['token'] ?? "";
        $checkTempData = TemporaryData::where("type", $gateway)->where("identifier", $token)->first();

        if (!$checkTempData) return redirect()->route('user.service.tracking.index')->with(['error' => ['Transaction faild. Record didn\'t saved properly. Please try again.']]);

        $checkTempData = $checkTempData->toArray();

        try {
            PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive();
        } catch (Exception $e) {

            return back()->with(['error' => [$e->getMessage()]]);
        }
        return redirect()->route('user.service.tracking.index')->with(['success' => ['Payment Successfully']]);
    }

    public function cancel(Request $request, $gateway)
    {

        $token = session()->get('identifier');
        if ($token) {
            TemporaryData::where("identifier", $token)->delete();
        }
        return redirect()->route('user.service.tracking.index');
    }

    public function payment($gateway)
    {

        $page_title = "Stripe Payment";
        $tempData = Session::get('identifier');
        $hasData = TemporaryData::where('identifier', $tempData)->where('type', $gateway)->first();
        if (!$hasData) {
            return redirect()->route('index');
        }
        return view('user.sections.add-money.automatic.' . $gateway, compact("page_title", "hasData"));
    }

    public function manualPayment()
    {
        $tempData = Session::get('identifier');
        $hasData = TemporaryData::where('identifier', $tempData)->first();
        $gateway = PaymentGateway::manual()->where('slug', PaymentGatewayConst::add_money_slug())->where('id', $hasData->data->gateway)->first();
        $page_title = "Manual Payment" . ' ( ' . $gateway->name . ' )';
        if (!$hasData) {
            return redirect()->route('user.service.tracking.index');
        }
        return view('user.sections.add-money.manual.payment_confirmation', compact("page_title", "hasData", 'gateway'));
    }

    //stripe success
    public function stripePaymentSuccess($trx)
    {

        $token = $trx;
        $checkTempData = TemporaryData::where("type", PaymentGatewayConst::STRIPE)->where("identifier", $token)->first();
        if (!$checkTempData) return redirect()->route('user.service.tracking.index')->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);

        $checkTempData = $checkTempData->toArray();

        try {
            PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive('stripe');
        } catch (Exception $e) {

            return back()->with(['error' => ["Something Is Wrong..." . $e->getMessage()]]);
        }

        return redirect()->route('user.service.tracking.index')->with(['success' => ['Payment Successfully']]);
    }

    public function flutterwaveCallback()
    {
        $status = request()->status;
        //if payment is successful
        if ($status ==  'successful') {

            $transactionID = Flutterwave::getTransactionIDFromCallback();
            $data = Flutterwave::verifyTransaction($transactionID);

            $requestData = request()->tx_ref;
            $token = $requestData;

            $checkTempData = TemporaryData::where("type", 'flutterwave')->where("identifier", $token)->first();

            if (!$checkTempData) return redirect()->route("index")->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);

            $checkTempData = $checkTempData->toArray();


            try {
                PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive('flutterWave');
            } catch (Exception $e) {

                return back()->with(['error' => [$e->getMessage()]]);
            }

            return redirect()->route('user.service.tracking.index')->with(['success' => ['Payment Successfully']]);
        } elseif ($status ==  'cancelled') {
            return redirect()->route('user.service.tracking.index')->with(['error' => ['Transaction failed']]);
        } else {
            return redirect()->route('user.service.tracking.index')->with(['error' => ['Transaction failed']]);
        }
    }

    public function razorPayment($trx_id)
    {
        $identifier = $trx_id;
        $output = TemporaryData::where('identifier', $identifier)->first();
        if (!$output) {
            return redirect()->route('user.service.tracking.index')->with(['error' => [__("Transaction failed")]]);
        }
        $data =  $output->data->response;
        $orderId =  $output->data->response->order_id;
        $page_title = __('razor Pay Payment');

        return view('user.sections.add-money.automatic.razor', compact('page_title', 'output', 'data', 'orderId'));
    }


    //sslcommerz success
    public function sllCommerzSuccess(Request $request)
    {
        $data = $request->all();
        $token = $data['tran_id'];
        $checkTempData = TemporaryData::where("type", PaymentGatewayConst::SSLCOMMERZ)->where("identifier", $token)->first();
        if (!$checkTempData) return redirect()->route('user.service.tracking.index')->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);
        $checkTempData = $checkTempData->toArray();
        $creator_id = $checkTempData['data']->creator_id ?? null;
        $creator_guard = $checkTempData['data']->creator_guard ?? null;

        $user = Auth::guard($creator_guard)->loginUsingId($creator_id);
        if ($data['status'] != "VALID") {
            return redirect()->route('user.service.tracking.index')->with(['error' => ['Payment Failed']]);
        }
        try {
            PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive('sslcommerz');
        } catch (Exception $e) {
            return back()->with(['error' => ["Something Is Wrong..." . $e->getMessage()]]);
        }
        return redirect()->route('user.service.tracking.index')->with(['success' => ['Payment Successfully']]);
    }
    //sslCommerz fails
    public function sllCommerzFails(Request $request)
    {
        $data = $request->all();
        $token = $data['tran_id'];
        $checkTempData = TemporaryData::where("type", PaymentGatewayConst::SSLCOMMERZ)->where("identifier", $token)->first();
        if (!$checkTempData) return redirect()->route('user.service.tracking.index')->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);
        $checkTempData = $checkTempData->toArray();
        $creator_id = $checkTempData['data']->creator_id ?? null;
        $creator_guard = $checkTempData['data']->creator_guard ?? null;
        $user = Auth::guard($creator_guard)->loginUsingId($creator_id);
        if ($data['status'] == "FAILED") {
            TemporaryData::destroy($checkTempData['id']);
            return redirect()->route('user.service.tracking.index')->with(['error' => ['Payment Failed']]);
        }
    }
    //sslCommerz canceled
    public function sllCommerzCancel(Request $request)
    {
        $data = $request->all();
        $token = $data['tran_id'];
        $checkTempData = TemporaryData::where("type", PaymentGatewayConst::SSLCOMMERZ)->where("identifier", $token)->first();
        if (!$checkTempData) return redirect()->route('index')->with(['error' => ['Transaction Failed. Record didn\'t saved properly. Please try again.']]);
        $checkTempData = $checkTempData->toArray();
        $creator_id = $checkTempData['data']->creator_id ?? null;
        $creator_guard = $checkTempData['data']->creator_guard ?? null;
        $user = Auth::guard($creator_guard)->loginUsingId($creator_id);
        if ($data['status'] != "VALID") {
            TemporaryData::destroy($checkTempData['id']);
            return redirect()->route('user.service.tracking.index')->with(['error' => ['Payment Canceled']]);
        }
    }
    public function qrpayCallback(Request $request)
    {

        if ($request->type ==  'success') {

            $requestData = $request->all();

            $checkTempData = TemporaryData::where("type", 'qrpay')->where("identifier", $requestData['data']['custom'])->first();

            if (!$checkTempData) return redirect()->route('user.service.tracking.index')->with(['error' => ['Transaction faild. Record didn\'t saved properly. Please try again.']]);

            $checkTempData = $checkTempData->toArray();


            try {
                PaymentGatewayHelper::init($checkTempData)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive('qrpay');
            } catch (Exception $e) {
                return back()->with(['error' => [$e->getMessage()]]);
            }
            return redirect()->route('user.service.tracking.index')->with(['success' => ['Payment Successfully']]);
        } else {
            return redirect()->route('user.service.tracking.index')->with(['error' => ['Transaction failed']]);
        }
    }

    public function qrpayCancel(Request $request, $trx_id)
    {
        TemporaryData::where("identifier", $trx_id)->delete();
        return redirect()->route('user.service.tracking.index')->with(['error' => ['Payment Canceled']]);
    }
    //razorpay update

    /**
     * Redirect Users for collecting payment via Button Pay (JS Checkout)
     */
    public function redirectBtnPay(Request $request, $gateway)
    {
        try {
            return PaymentGatewayHelper::init([])->type('ADD-MONEY')->handleBtnPay($gateway, $request->all());
        } catch (Exception $e) {
            return redirect()->route('index')->with(['error' => [$e->getMessage()]]);
        }
    }

    public function postSuccess(Request $request, $gateway)
    {
        try {
            $token = PaymentGatewayHelper::getToken($request->all(), $gateway);
            $temp_data = TemporaryData::where("identifier", $token)->first();
            Auth::guard($temp_data->data->creator_guard)->loginUsingId($temp_data->data->creator_id);
        } catch (Exception $e) {
            return redirect()->route('index');
        }
        return $this->successGlobal($request, $gateway);
    }

    public function postCancel(Request $request, $gateway)
    {
        try {
            $token = PaymentGatewayHelper::getToken($request->all(), $gateway);
            $temp_data = TemporaryData::where("identifier", $token)->first();
            Auth::guard($temp_data->data->creator_guard)->loginUsingId($temp_data->data->creator_id);
        } catch (Exception $e) {
            return redirect()->route('index');
        }
        return $this->cancelGlobal($request, $gateway);
    }

    public function successGlobal(Request $request, $gateway)
    {
        try {
            $token = PaymentGatewayHelper::getToken($request->all(), $gateway);
            $temp_data = TemporaryData::where("identifier", $token)->first();
            if (Transaction::where('callback_ref', $token)->exists()) {
                if (!$temp_data) return redirect()->route('index')->with(['success' => [__('Transaction request sended successfully!')]]);
            } else {
                if (!$temp_data) return redirect()->route('index')->with(['error' => [__('Transaction failed. Record didn\'t saved properly. Please try again')]]);
            }

            $update_temp_data = json_decode(json_encode($temp_data->data), true);
            $update_temp_data['callback_data']  = $request->all();
            $temp_data->update([
                'data'  => $update_temp_data,
            ]);
            $temp_data = $temp_data->toArray();
            $instance = PaymentGatewayHelper::init($temp_data)->type(PaymentGatewayConst::TYPEADDMONEY)->responseReceive($temp_data['type']);
            if ($instance instanceof RedirectResponse) return $instance;
        } catch (Exception $e) {

            return back()->with(['error' => [$e->getMessage()]]);
        }
        return redirect()->route('user.service.tracking.index')->with(['success' => ['Payment Successfully']]);
    }

    public function cancelGlobal(Request $request, $gateway)
    {
        $token = PaymentGatewayHelper::getToken($request->all(), $gateway);
        if ($temp_data = TemporaryData::where("identifier", $token)->first()) {
            $temp_data->delete();
        }
        return redirect()->route('index');
    }

    public function callback(Request $request, $gateway)
    {
        $callback_token = $request->get('token');
        $callback_data = $request->all();
        try {
            PaymentGatewayHelper::init([])->type(PaymentGatewayConst::TYPEADDMONEY)->handleCallback($callback_token, $callback_data, $gateway);
        } catch (Exception $e) {
            // handle Error
            logger($e);
        }
    }
}
