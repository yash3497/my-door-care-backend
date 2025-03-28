<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\UserWallet;
use App\Models\Transaction;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Models\TemporaryData;
use App\Models\Admin\Currency;
use App\Models\UserNotification;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\BasicSettings;
use App\Constants\NotificationConst;
use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentGateway;
use App\Constants\PaymentGatewayConst;
use App\Traits\ControlDynamicInputFields;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class SellCoinController extends Controller
{
    use ControlDynamicInputFields;
    public function sellCoinInfo()
    {
        $user = auth()->user();


        $transactions = Transaction::auth()->sellCoin()->latest()->take(5)->get()->map(function ($item) {
            $statusInfo = [
                "success" =>      1,
                "pending" =>      2,
                "rejected" =>     3,
            ];

            return [
                'id' => $item->id,
                'trx' => $item->trx_id,
                'transaction_type' => $item->type,
                'receiving_gateway_currency_name' => $item->details->total_info->charge->receiver_method_code,
                'receiving_amount' => getAmount($item->details->total_info->receiving_amount, 2) . ' ' . $item->details->total_info->charge->sender_method_code,
                'sender_gateway_name' => $item->details->total_info->receiving_gateway,
                'sender_gateway_currency_name' => $item->details->total_info->charge->sender_method_code,
                'sender_amount' => getAmount($item->details->total_info->charge->will_get, 2) . ' ' . $item->details->total_info->charge->sender_method_code,
                'payable' => getAmount($item->details->total_info->charge->will_get, 2) . ' ' . $item->details->total_info->charge->sender_method_code,
                'exchange_rate' => getAmount($item->details->total_info->charge->exchange_rate, 2) . ' ' . $item->details->total_info->charge->sender_method_code,
                'total_charge' => getAmount($item->details->total_info->charge->rtotal_charge, 2) . ' ' . $item->details->total_info->charge->sender_method_code,
                'status' => $item->stringStatus->value,
                'date_time' => $item->created_at,
                'status_info' => (object)$statusInfo,
                'rejection_reason' => $item->reject_reason ?? "",

            ];
        });

        $sender_gateways = PaymentGateway::where('status', 1)->where('slug', PaymentGatewayConst::money_out_slug())->get()->map(function ($gateway) {
            $currencies = PaymentGatewayCurrency::where('payment_gateway_id', $gateway->id)->get()->map(function ($data) {
                return [
                    'id' => $data->id,
                    'payment_gateway_id' => $data->payment_gateway_id,
                    'type' => $data->gateway->type,
                    'name' => $data->name,
                    'alias' => $data->alias,
                    'currency_code' => $data->currency_code,
                    'currency_symbol' => $data->currency_symbol,
                    'image' => $data->image,
                    'min_limit' => getAmount($data->min_limit, 2),
                    'max_limit' => getAmount($data->max_limit, 2),
                    'percent_charge' => getAmount($data->percent_charge, 2),
                    'fixed_charge' => getAmount($data->fixed_charge, 2),
                    'rate' => getAmount($data->rate, 2),
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                ];
            });
            return [
                'id' => $gateway->id,
                'image' => $gateway->image,
                'slug' => $gateway->slug,
                'code' => $gateway->code,
                'type' => $gateway->type,
                'alias' => $gateway->alias,
                'supported_currencies' => $gateway->supported_currencies,
                'input_fields' => $gateway->input_fields ?? null,
                'status' => $gateway->status,
                'currencies' => $currencies

            ];
        });
        $receiver_gateways = PaymentGateway::where('status', 1)->where('slug', PaymentGatewayConst::sell_coin_slug())->get()->map(function ($gateway) {
            $currencies = PaymentGatewayCurrency::where('payment_gateway_id', $gateway->id)->get()->map(function ($data) {
                return [
                    'id' => $data->id,
                    'payment_gateway_id' => $data->payment_gateway_id,
                    'type' => $data->gateway->type,
                    'name' => $data->name,
                    'alias' => $data->alias,
                    'currency_code' => $data->currency_code,
                    'currency_symbol' => $data->currency_symbol,
                    'image' => $data->image,
                    'min_limit' => getAmount($data->min_limit, 2),
                    'max_limit' => getAmount($data->max_limit, 2),
                    'percent_charge' => getAmount($data->percent_charge, 2),
                    'fixed_charge' => getAmount($data->fixed_charge, 2),
                    'rate' => getAmount($data->rate, 2),
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at,
                ];
            });
            return [
                'id' => $gateway->id,
                'image' => $gateway->image,
                'slug' => $gateway->slug,
                'code' => $gateway->code,
                'type' => $gateway->type,
                'alias' => $gateway->alias,
                'supported_currencies' => $gateway->supported_currencies,
                'input_fields' => $gateway->input_fields ?? null,
                'status' => $gateway->status,
                'currencies' => $currencies

            ];
        });
        $data = [
            'base_curr'    => get_default_currency_code(),
            'base_curr_rate'    => getAmount(1, 2),
            'default_image'    => "public/backend/images/default/default.webp",
            "image_path"  =>  "public/backend/images/payment-gateways",

            'receiver_gateways'   => $receiver_gateways,
            'sender_gateways'   => $sender_gateways,
            'transactionss'   =>   $transactions,
        ];
        $message =  ['success' => ['Sell Coin Information!']];
        return ApiResponse::success($message, $data);
    }
    public function sellCoinInsert(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|gt:0',
            'gateway' => 'required'
        ]);
        if ($validator->fails()) {
            $error =  ['error' => $validator->errors()->all()];
            return ApiResponse::validation($error);
        }
        $recever_gate = PaymentGatewayCurrency::whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::sell_coin_slug());
            $gateway->where('status', 1);
        })->first();

        $payment_fields = $recever_gate->gateway->input_fields ?? [];
        $validation_rules = $this->generateValidationRules($payment_fields);

        $validator2 = Validator::make($request->all(), $validation_rules);
        if ($validator2->fails()) {
            $message =  ['error' => $validator2->errors()->all()];
            return ApiResponse::error($message);
        }
        $validated = $validator2->validate();
        $get_values = $this->placeValueWithFields($payment_fields, $validated);

        $user = auth()->user();

        $sender_gate = PaymentGatewayCurrency::whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::money_out_slug());
            $gateway->where('status', 1);
        })->where('alias', $request->gateway)->first();
        if (!$sender_gate) {
            $error = ['error' => ['Invalid Gateway!']];
            return ApiResponse::error($error);
        }
        $baseCurrency = Currency::default();
        if (!$baseCurrency) {
            $error = ['error' => ['Default Currency Not Setup Yet!']];
            return ApiResponse::error($error);
        }
        $amount = $request->amount;

        $min_limit =  $recever_gate->min_limit;
        $max_limit =  $recever_gate->max_limit;
        if ($amount < $min_limit || $amount > $max_limit) {
            $error = ['error' => ['Please follow the transaction limit!']];
            return ApiResponse::error($error);
        }
        $charges = $this->sellCoinCharges($amount, $recever_gate, $sender_gate); // Withdraw charge

        $data = [
            'receiving_gateway' => $sender_gate->gateway->alias,
            'receiving_amount' => $amount,

            'charge' => $charges,
        ];

        try {
            $token = generate_unique_string("temporary_datas", "identifier", 16);
            $inserted = TemporaryData::create([
                'type'          => PaymentGatewayConst::sell_coin_slug(),
                'identifier'    => $token,
                'data'          => $data
            ]);
            if ($inserted) {

                $payment_informations = [
                    'trx' =>  $token,
                    'request_amount' => getAmount($request->amount, 2) . ' ' . $recever_gate->currency_code,
                    'total_charge' => getAmount($charges->rtotal_charge, 2) . ' ' . $charges->receiver_method_code,
                    'conversion_amount' =>  getAmount($charges->convirsion_amount, 2) . ' ' . $charges->receiver_method_code,
                    'will_get' => getAmount($charges->will_get, 2) . ' ' . $sender_gate->currency_code,

                ];
                $data = [
                    'payment_informations' => $payment_informations,
                    'gateway_name' => $sender_gate->gateway->name,
                    'gateway_alias' => $sender_gate->gateway->alias,
                    'gateway_type' => $sender_gate->gateway->type,
                    'gateway_currency_name' => $sender_gate->name,
                    'gateway_currency_alias' => $sender_gate->alias,
                    'details' => $sender_gate->gateway->desc ?? null,
                    'input_fields' => $sender_gate->gateway->input_fields ?? null,
                    'url' => route('api.v1.user.sell.coin.confirmed'),
                    'method' => "post",
                ];
                $message =  ['success' => ['Sell Coin Inserted Successfully']];
                return ApiResponse::success($message, $data);
            } else {
                $error = ['error' => ['Something is wrong!']];
                return ApiResponse::error($error);
            }
        } catch (Exception $e) {
            $error = ['error' => ['Something is wrong!']];
            return ApiResponse::error($error);
        }
    }



    public function sellCoinConfirmed(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'trx'  => "required",
        ]);
        if ($validator->fails()) {
            $error =  ['error' => $validator->errors()->all()];
            return ApiResponse::validation($error);
        }

        $tempData = TemporaryData::where('identifier', $request->trx)->where('type', PaymentGatewayConst::TYPESELLCOIN)->first();

        if (!$tempData) {
            $error = ['error' => ["Sorry, your payment information is invalid"]];
            return ApiResponse::error($error);
        }

        $gateway_currency_id = $tempData->data->receiving_gateway ?? "";

        if (!$gateway_currency_id) {
            $error = ['error' => ["Invalid request"]];
            return ApiResponse::error($error);
        }
        $gateway = PaymentGateway::moneyOut()->manual()->where('alias', $tempData->data->receiving_gateway)->first();
        if (!$gateway) {
            $error = ['error' => ["Invalid gateway..."]];
            return ApiResponse::error($error);
        };

        $payment_fields = $gateway->input_fields ?? [];
        $validation_rules = $this->generateValidationRules($payment_fields);
        $validator2 = Validator::make($request->all(), $validation_rules);
        if ($validator2->fails()) {
            $message =  ['error' => $validator2->errors()->all()];
            return ApiResponse::error($message);
        }
        $validated = $validator2->validate();
        $get_values = $this->placeValueWithFields($payment_fields, $validated);

        $gateway_currency = PaymentGatewayCurrency::where('payment_gateway_id', $gateway->id)->first();
        if (!$gateway_currency) return redirect()->route('user.sell.coin.index')->with(['error' => ['Payment gateway currency is invalid!']]);
        $amount = $tempData->data->charge;

        // Make Transaction
        DB::beginTransaction();
        try {
            $id = DB::table("transactions")->insertGetId([
                'user_id'                       => auth()->user()->id,
                'user_wallet_id'                => null,
                'payment_gateway_currency_id'   => $gateway_currency->id,
                'type'                          => PaymentGatewayConst::TYPESELLCOIN,
                'trx_id'                        => generate_unique_string('transactions', 'trx_id', 16),
                'request_amount'                => $amount->request_amount,
                'payable'                       => 0,
                'available_balance'             => 0,
                'details'                       => json_encode(['sender_input' => $get_values, 'total_info' => $tempData->data]),
                'status'                        => PaymentGatewayConst::STATUSPENDING,
                'attribute'                     => PaymentGatewayConst::SEND,
                'created_at'                    => now(),
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $error = ['error' => ['Something is wrong!']];
            return ApiResponse::error($error);
        }
        $tempData->delete();

        $message = ['success' => ['Transaction success! Please wait for confirmation']];
        return ApiResponse::onlysuccess($message);
    }





    public function sellCoinCharges($amount, $receiverMethod, $senderMethod)
    {
        $baseCurRate = Currency::default()->first();
        $baseCurRate = $baseCurRate->rate;
        $senderCurRate =  $baseCurRate / $senderMethod->rate;
        $receiverCurRate =  $baseCurRate / $receiverMethod->rate;

        $excahngeRate = $receiverCurRate / $senderCurRate;



        $data['exchange_rate']          = $excahngeRate;
        $data['request_amount']         = $amount;


        $data['sender_method_code']     = $senderMethod->currency_code;

        $data['rfixed_charge']           = $receiverMethod->fixed_charge;
        $data['rpercent_charge']         = ($amount / 100) *  $receiverMethod->percent_charge;
        $data['rtotal_charge']           = $data['rfixed_charge'] + $data['rpercent_charge'];
        $data['receiver_method_code']   = $receiverMethod->currency_code;

        $data['convirsion_amount']         = $amount - $data['rtotal_charge'];


        $data['will_get']               = $data['convirsion_amount'] * $excahngeRate;

        return (object) $data;
    }

    function receiverConfirm(Request $request)
    {
        $recever_gate = PaymentGatewayCurrency::whereHas('gateway', function ($gateway) {
            $gateway->where('slug', PaymentGatewayConst::sell_coin_slug());
            $gateway->where('status', 1);
        })->where('alias', 'receiving-method-aud-manual')->first();



        $payment_fields = $recever_gate->gateway->input_fields ?? [];
        $validation_rules = $this->generateValidationRules($payment_fields);

        $validator2 = Validator::make($request->all(), $validation_rules);
        if ($validator2->fails()) {
            $message =  ['error' => $validator2->errors()->all()];
            return ApiResponse::error($message);
        }
        $validated = $validator2->validate();
        $get_values = $this->placeValueWithFields($payment_fields, $validated);

        $message = ['success' => ['Transaction success! Please wait for confirmation']];

        $message = ['success' => ['Transaction success! Please wait for confirmation']];
        return ApiResponse::success($message, $get_values);
    }
}
