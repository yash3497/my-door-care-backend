<?php

namespace App\Traits\PaymentGateway;

use Exception;
use App\Models\Transaction;
use App\Models\UserRequest;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use App\Models\TemporaryData;
use Illuminate\Support\Carbon;
use App\Models\UserNotification;
use App\Models\NannyNotification;
use Illuminate\Support\Facades\DB;
use App\Constants\NotificationConst;
use App\Constants\PaymentGatewayConst;
use App\Providers\Admin\BasicSettingsProvider;
use App\Notifications\User\AddMoney\ApprovedMail;
use App\Notifications\User\SitterHub\PaymentMail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

trait Paypal
{
    public function paypalInit($output = null)
    {
        if (!$output) $output = $this->output;
        $credentials = $this->getPaypalCredetials($output);

        $config = $this->paypalConfig($credentials, $output['amount']);
        $paypalProvider = new PayPalClient;
        $paypalProvider->setApiCredentials($config);
        $paypalProvider->getAccessToken();
        $response = $paypalProvider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('user.add.money.payment.success', PaymentGatewayConst::PAYPAL),
                "cancel_url" => route('user.add.money.payment.cancel', PaymentGatewayConst::PAYPAL),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $output['amount']->sender_cur_code ?? '',
                        "value" => $output['amount']->total_amount ? number_format($output['amount']->total_amount, 2, '.', '') : 0,
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != "" && isset($response['status']) && $response['status'] == "CREATED" && isset($response['links']) && is_array($response['links'])) {
            foreach ($response['links'] as $item) {
                if ($item['rel'] == "approve") {
                    $this->paypalJunkInsert($response);
                    return redirect()->away($item['href']);
                    break;
                }
            }
        }

        if (isset($response['error']) && is_array($response['error'])) {
            throw new Exception($response['error']['message']);
        }

        throw new Exception("Something went worng! Please try again.");
    }

    public function getPaypalCredetials($output)
    {
        $gateway = $output['gateway'] ?? null;
        if (!$gateway) throw new Exception("Payment gateway not available");
        $client_id_sample = ['api key', 'api_key', 'client id', 'primary key'];
        $client_secret_sample = ['client_secret', 'client secret', 'secret', 'secret key', 'secret id'];

        $client_id = '';
        $outer_break = false;
        foreach ($client_id_sample as $item) {
            if ($outer_break == true) {
                break;
            }
            $modify_item = $this->paypalPlainText($item);
            foreach ($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = $this->paypalPlainText($label);

                if ($label == $modify_item) {
                    $client_id = $gatewayInput->value ?? "";
                    $outer_break = true;
                    break;
                }
            }
        }

        $secret_id = '';
        $outer_break = false;
        foreach ($client_secret_sample as $item) {
            if ($outer_break == true) {
                break;
            }
            $modify_item = $this->paypalPlainText($item);
            foreach ($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = $this->paypalPlainText($label);

                if ($label == $modify_item) {
                    $secret_id = $gatewayInput->value ?? "";
                    $outer_break = true;
                    break;
                }
            }
        }

        return (object) [
            'client_id'     => $client_id,
            'client_secret' => $secret_id,
            'mode'          => "sandbox",
        ];
    }

    public function paypalPlainText($string)
    {
        $string = Str::lower($string);
        return preg_replace("/[^A-Za-z0-9]/", "", $string);
    }
    public static function paypalConfig($credentials, $amount_info)
    {
        $config = [
            'mode'    => $credentials->mode ?? 'sandbox',
            'sandbox' => [
                'client_id'         => $credentials->client_id ?? "",
                'client_secret'     => $credentials->client_secret ?? "",
                'app_id'            => "APP-80W284485P519543T",
            ],
            'live' => [
                'client_id'         => $credentials->client_id ?? "",
                'client_secret'     => $credentials->client_secret ?? "",
                'app_id'            => "",
            ],
            'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => $amount_info->sender_cur_code ?? "",
            'notify_url'     => "", // Change this accordingly for your application.
            'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true, // Validate SSL when creating api client.
        ];
        return $config;
    }

    public function paypalJunkInsert($response)
    {

        $output = $this->output;

        if ("ORDER" == $output['type']) {

            $data = [
                'gateway'   => $output['gateway']->id,
                'currency'  => $output['currency']->id,
                'amount'    => json_decode(json_encode($output['amount']), true),
                'response'  => $response,
                'wallet_table'  => $output['wallet']->getTable(),
                'wallet_id'     => $output['wallet']->id,
                'creator_table' => auth()->guard(get_auth_guard())->user()->getTable(),
                'creator_id'    => auth()->guard(get_auth_guard())->user()->id,
                'creator_guard' => get_auth_guard(),
                'type' => $output['type'],
                'billingTempData' => $output['billingTempData']['data'] ?? '',
            ];
        } else {
            $data = [
                'gateway'   => $output['gateway']->id,
                'currency'  => $output['currency']->id,
                'amount'    => json_decode(json_encode($output['amount']), true),
                'response'  => $response,
                'wallet_table'  => $output['wallet']->getTable(),
                'wallet_id'     => $output['wallet']->id,
                'creator_table' => auth()->guard(get_auth_guard())->user()->getTable(),
                'creator_id'    => auth()->guard(get_auth_guard())->user()->id,
                'creator_guard' => get_auth_guard(),
                'type' => $output['type'],
            ];
        }

        return TemporaryData::create([
            'type'          => PaymentGatewayConst::PAYPAL,
            'identifier'    => $response['id'],
            'data'          => $data,
        ]);
    }

    public function paypalSuccess($output = null)
    {
        if (!$output) $output = $this->output;
        $user_request_id = $output['amount']->user_request_id;
        $user_request_data = UserRequest::where('id', $user_request_id)->first();
        $output['nanny_wallet'] = $user_request_data->nanny->nanny_wallet;
        $token = $this->output['tempData']['identifier'] ?? "";

        $credentials = $this->getPaypalCredetials($output);
        $config = $this->paypalConfig($credentials, $output['amount']);
        $paypalProvider = new PayPalClient;
        $paypalProvider->setApiCredentials($config);
        $paypalProvider->getAccessToken();
        $response = $paypalProvider->capturePaymentOrder($token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return $this->paypalPaymentCaptured($response, $output);
        } else {
            throw new Exception('Transaction faild. Payment captured faild.');
        }

        if (empty($token)) throw new Exception('Transaction faild. Record didn\'t saved properly. Please try again.');
    }

    public function paypalPaymentCaptured($response, $output)
    {
        // payment successfully captured record saved to database
        $output['capture'] = $response;
        try {
            $this->createTransaction($output);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return true;
    }

    public function createTransaction($output)
    {
        $basic_setting = BasicSettingsProvider::get();
        $user = auth()->user();
        $user_request = UserRequest::where('user_id', $user->id)->first();
        $trx_id = 'AM' . getTrxNum();

        $inserted_id = $this->insertRecord($output);

        $this->insertCharges($output, $inserted_id);
        $this->insertDevice($output, $inserted_id);
        $this->removeTempData($output);

        if ($basic_setting->email_notification == true) {
            $user->notify(new PaymentMail($user, $output, $trx_id, $user_request));
        }
    }

    public function insertRecord($output)
    {
        $trx_id = generate_unique_string("transactions", "trx_id", 16);
        $token = $this->output['tempData']['identifier'] ?? "";

        $user_request = UserRequest::findOrFail($output['amount']->user_request_id);
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

        DB::beginTransaction();
        try {
            $id = DB::table("transactions")->insertGetId([
                'user_id'                       => auth()->user()->id,
                'nanny_id'                      => $user_request->nanny_id,
                'nanny_wallet_id'                => $output['nanny_wallet']->id,
                'payment_gateway_currency_id'   => $output['currency']->id,
                'type'                          => $output['type'],
                'trx_id'                        => $trx_id,
                'request_amount'                => $user_request->total,
                'payable'                       => $user_request->payable,
                'available_balance'             => $output['nanny_wallet']->balance + $output['amount']->requested_amount,
                'remark'                        => ucwords(remove_speacial_char($output['type'], " ")) . " With " . $output['gateway']->name,
                'details'                       =>  json_encode($data),
                'status'                        => true,
                'created_at'                    => now(),
            ]);

            $this->updateWalletBalance($output);

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

    public function updateWalletBalance($output)
    {
        $update_amount = $output['nanny_wallet']->balance + $output['amount']->requested_amount;

        $output['nanny_wallet']->update([
            'balance'   => $update_amount,
        ]);
    }

    public function insertCharges($output, $id)
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

            //notification
            $notification_content = [
                'title'         => "Payment",
                'message'       => $output['amount']->requested_amount . ' ' . $output['amount']->default_currency . ' payment successfully',
                'time'          => Carbon::now()->diffForHumans(),
                'image'         => files_asset_path('profile-default'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::BALANCE_ADDED,
                'user_id'  =>  auth()->user()->id,
                'message'   => $notification_content,
            ]);
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function insertDevice($output, $id)
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

    public function removeTempData($output)
    {
        $token = $output['capture']['id'];
        TemporaryData::where("identifier", $token)->delete();
    }

    public function paypalInitApi($output = null)
    {
        if (!$output) $output = $this->output;
        $credentials = $this->getPaypalCredetials($output);

        $config = $this->paypalConfig($credentials, $output['amount']);
        $paypalProvider = new PayPalClient;
        $paypalProvider->setApiCredentials($config);
        $paypalProvider->getAccessToken();

        $response = $paypalProvider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('api.v1.user.api.payment.success', PaymentGatewayConst::PAYPAL . "?r-source=" . PaymentGatewayConst::APP),
                "cancel_url" => route('api.v1.user.api.payment.cancel', PaymentGatewayConst::PAYPAL . "?r-source=" . PaymentGatewayConst::APP),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => $output['amount']->sender_cur_code ?? '',
                        "value" => $output['amount']->total_amount ? number_format($output['amount']->total_amount, 2, '.', '') : 0,
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != "" && isset($response['status']) && $response['status'] == "CREATED" && isset($response['links']) && is_array($response['links'])) {
            foreach ($response['links'] as $item) {
                if ($item['rel'] == "approve") {
                    $this->paypalJunkInsert($response);
                    return $response;
                    break;
                }
            }
        }

        if (isset($response['error']) && is_array($response['error'])) {
            throw new Exception($response['error']['message']);
        }

        throw new Exception("Something went worng! Please try again.");
    }
}
