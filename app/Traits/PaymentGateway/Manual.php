<?php

namespace App\Traits\PaymentGateway;

use Exception;
use App\Models\Transaction;
use App\Models\UserRequest;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Models\TemporaryData;
use Illuminate\Support\Carbon;
use App\Models\UserNotification;
use App\Models\NannyNotification;
use Illuminate\Support\Facades\DB;
use App\Constants\NotificationConst;
use App\Http\Helpers\PaymentGateway;
use App\Constants\PaymentGatewayConst;
use Illuminate\Support\Facades\Session;
use App\Traits\ControlDynamicInputFields;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Api\PaymentGatewayApi;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Http\Helpers\Api\Helpers as ApiResponse;
use App\Http\Controllers\User\AddMoneyController;
use App\Models\Admin\PaymentGateway as PaymentGatewayModel;

trait Manual
{
    use ControlDynamicInputFields;

    protected $user_request_id = 'user_request_id';

    public function manualInit($output = null)
    {
        if (!$output) $output = $this->output;
        $gatewayAlias = $output['gateway']['alias'];
        $identifier = generate_unique_string("transactions", "trx_id", 16);
        $this->manualJunkInsert($identifier);
        Session::put('identifier', $identifier);
        Session::put('output', $output);
        return redirect()->route('user.add.money.manual.payment');
    }

    public function manualJunkInsert($response)
    {

        $output = $this->output;


        $data = [
            'gateway'   => $output['gateway']->id,
            'currency'  => $output['currency']->id,
            'amount'    => json_decode(json_encode($output['amount']), true),
            'response'  => $response,
        ];

        return TemporaryData::create([
            'type'          => PaymentGatewayConst::MANUA_GATEWAY,
            'identifier'    => $response,
            'data'          => $data,
        ]);
    }
    public function manualPaymentConfirmed(Request $request)
    {

        $output = session()->get('output');
        $tempData = Session::get('identifier');
        $hasData = TemporaryData::where('identifier', $tempData)->first();
        $gateway = PaymentGatewayModel::manual()->where('slug', PaymentGatewayConst::add_money_slug())->where('id', $hasData->data->gateway)->first();
        $payment_fields = $gateway->input_fields ?? [];

        $validation_rules = $this->generateValidationRules($payment_fields);

        $payment_field_validate = Validator::make($request->all(), $validation_rules)->validate();
        $get_values = $this->placeValueWithFields($payment_fields, $payment_field_validate);


        try {
            $inserted_id = $this->insertRecordManual($output, $get_values);
            $this->insertChargesManual($output, $inserted_id);
            $this->insertDeviceManual($output, $inserted_id);
            $this->removeTempDataManual($output);
            return redirect()->route('user.service.tracking.index')->with(['success' => ['Payment request send to admin successfully']]);
        } catch (Exception $e) {
            return back()->with(['error' => [$e->getMessage()]]);
        }
    }

    public function insertRecordManual($output, $get_values)
    {
        $trx_id = generate_unique_string("transactions", "trx_id", 16);
        $token = $this->output['tempData']['identifier'] ?? "";

        $user_request = UserRequest::findOrFail($output['amount']->user_request_id);
        $user_id = auth()->guard(get_auth_guard())->user()->id;

        $data = [
            'add_baby_pet_id' => $user_request->add_baby_pet_id,
            'started_date' => $user_request->started_date,
            'end_date' => $user_request->end_date,
            'service_type' => $user_request->service_type,
            'service_day' => $user_request->service_day,
            'daily_working_hour' => $user_request->daily_working_hour,
            'total_hour' => $user_request->total_hour,
            'nanny_charge' => $user_request->nanny_charge,
            'started_time' => $user_request->started_time,
            'total' => $user_request->total,
            'service_charge' => $user_request->service_charge,
            'currency_code' => $user_request->currency_code,
            'address' => $user_request->address,
            'status' => $user_request->status,
        ];
        $payment_info['payment_info'] = $get_values;
        $order_and_payment_details = array_merge($data, $payment_info);
        DB::beginTransaction();
        try {
            $id = DB::table("transactions")->insertGetId([
                'user_id'                       => auth()->user()->id,
                'user_wallet_id'                => $output['wallet']->id,
                'payment_gateway_currency_id'   => $output['currency']->id,
                'type'                          => PaymentGatewayConst::TYPEADDMONEY,
                'trx_id'                        => $trx_id,
                'request_amount'                => $output['amount']->requested_amount,
                'payable'                       => $output['amount']->total_amount,
                'available_balance'             => $output['wallet']->balance,
                'remark'                        => ucwords(remove_speacial_char(PaymentGatewayConst::TYPEADDMONEY, " ")) . " With " . $output['gateway']->name,
                'details'                       => json_encode($order_and_payment_details),
                'status'                        => 2,
                'created_at'                    => now(),
            ]);

            $user_request->update([
                'status' => 5
            ]);

            //notification
            $notification_content = [
                'title'         => "Payment Successfully",
                'message'       => $output['amount']->requested_amount . ' ' . $output['amount']->default_currency . ' payment successfully',
                'time'          => Carbon::now()->diffForHumans(),
                'image'         => files_asset_path('profile-default'),
            ];

            NannyNotification::create([
                'type'      => NotificationConst::USER_PAYMENT,
                'nanny_id'  =>  $user_request->nanny_id,
                'message'   => $notification_content,
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        return $id;
    }


    public function insertChargesManual($output, $id)
    {
        DB::beginTransaction();
        try {
            DB::table('transaction_charges')->insert([
                'transaction_id'    => $id,
                'percent_charge'    => $output['amount']->percent_charge,
                'fixed_charge'      => $output['amount']->fixed_charge,
                'total_charge'      => $output['amount']->total_charge,
                'created_at'        => now(),
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function insertDeviceManual($output, $id)
    {
        $client_ip = request()->ip() ?? false;
        $location = geoip()->getLocation($client_ip);
        $agent = new Agent();

        $mac = "";

        DB::beginTransaction();
        try {
            DB::table("transaction_devices")->insert([
                'transaction_id' => $id,
                'ip'            => $client_ip,
                'mac'           => $mac,
                'city'          => $location['city'] ?? "",
                'country'       => $location['country'] ?? "",
                'longitude'     => $location['lon'] ?? "",
                'latitude'      => $location['lat'] ?? "",
                'timezone'      => $location['timezone'] ?? "",
                'browser'       => $agent->browser() ?? "",
                'os'            => $agent->platform() ?? "",
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function removeTempDataManual($output)
    {
        $token = session()->get('identifier');
        TemporaryData::where("identifier", $token)->delete();
    }

    //for api
    public function manualInitApi($output = null)
    {
        if (!$output) $output = $this->output;
        $gatewayAlias = $output['gateway']['alias'];
        $identifier = generate_unique_string("transactions", "trx_id", 16);
        $this->manualJunkInsert($identifier);
        $response = [
            'trx' => $identifier,
        ];
        return $response;
    }

    public function manualPaymentConfirmedApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'track' => 'required',
        ]);
        if ($validator->fails()) {
            $error =  ['error' => $validator->errors()->all()];
            return ApiResponse::validation($error);
        }
        $track = $request->track;
        $hasData = TemporaryData::where('identifier', $track)->first();

        if (!$hasData) {
            $error = ['error' => ["Sorry, your payment information is invalid"]];
            return ApiResponse::error($error);
        }
        $gateway = PaymentGatewayModel::manual()->where('slug', PaymentGatewayConst::add_money_slug())->where('id', $hasData->data->gateway)->first();
        $payment_fields = $gateway->input_fields ?? [];

        $validation_rules = $this->generateValidationRules($payment_fields);
        $validator2 = Validator::make($request->all(), $validation_rules);

        if ($validator2->fails()) {
            $message =  ['error' => $validator2->errors()->all()];
            return ApiResponse::error($message);
        }
        $validated = $validator2->validate();
        $get_values = $this->placeValueWithFields($payment_fields, $validated);
        $payment_gateway_currency = PaymentGatewayCurrency::where('id', $hasData->data->currency)->first();
        $gateway_request =
            [
                'currency' => $payment_gateway_currency->alias,
                'amount'  => $hasData->data->amount->requested_amount,
                $this->user_request_id     => $hasData['data']->amount->user_request_id
            ];
        $output = PaymentGatewayApi::init($gateway_request)->gateway()->get();


        try {
            $trx_id = 'AM' . getTrxNum();
            $user = auth()->user();

            $inserted_id = $this->insertRecordManual($output, $get_values, $trx_id);
            $this->insertChargesManual($output, $inserted_id);
            $this->insertDeviceManual($output, $inserted_id);
            $hasData->delete();
            $message =  ['success' => ['Payment request send to admin successfully']];
            return ApiResponse::onlysuccess($message);
        } catch (Exception $e) {
            $error = ['error' => [$e->getMessage()]];
            return ApiResponse::error($error);
        }
    }
}
