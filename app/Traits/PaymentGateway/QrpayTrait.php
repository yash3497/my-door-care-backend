<?php

namespace App\Traits\PaymentGateway;

use Exception;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Constants\PaymentGatewayConst;
use Illuminate\Support\Facades\Session;
use App\Providers\Admin\BasicSettingsProvider;
use App\Notifications\User\AddMoney\ApprovedMail;
use App\Notifications\User\SitterHub\PaymentMail;


trait QrpayTrait
{
    public function qrpayInit($output = null)
    {

        if (!$output) $output = $this->output;
        $request_data = $this->request_data;
        $credentials = $this->getQrpayCredetials($output);
        $access = $this->accessTokenQrpay($credentials);

        $identifier = generate_unique_string("transactions", "trx_id", 16);

        $this->QrpayJunkInsert($identifier);


        $return_url = route('user.add.money.qrpay.callback');
        $cancel_url = route('user.add.money.qrpay.cancel', $identifier);


        $token = $access->data->access_token;
        // Payment Url Request

        $amount = $output['amount']->total_amount ? number_format($output['amount']->total_amount, 2, '.', '') : 0;

        if (PaymentGatewayConst::ENV_SANDBOX == $credentials->mode) {
            $base_url = $credentials->base_url_sandbox;
        } elseif (PaymentGatewayConst::ENV_PRODUCTION == $credentials->mode) {
            $base_url = $credentials->base_url_production;
        }


        $response = Http::withToken($token)->post($base_url . '/payment/create', [
            'amount'     => $amount,
            'currency'   => "USD",
            'return_url' => $return_url,
            'cancel_url' => $cancel_url,
            'custom'   => $identifier,
        ]);


        $statusCode = $response->getStatusCode();
        $content    = json_decode($response->getBody()->getContents());

        if ($content->type == 'error') {
            $errors = implode($content->message->error);
            throw new Exception($errors);
        }


        return redirect()->away($content->data->payment_url);
    }
    // ********* For API **********
    public function qrpayInitApi($output = null)
    {

        if (!$output) $output = $this->output;

        $request_data = $this->request_data;
        $credentials = $this->getQrpayCredetials($output);

        $access = $this->accessTokenQrpay($credentials);
        $identifier = generate_unique_string("transactions", "trx_id", 16);

        $this->QrpayJunkInsert($identifier);

        if ('ORDER' == $output['type']) {
            $return_url = route('top.up.qrpay.callback');
            $cancel_url = route('top.up.qrpay.cancel', $identifier);
        } else {
            $return_url = route('api.v1.api.qrpay.callback', "r-source=" . PaymentGatewayConst::APP);
            $cancel_url = route('api.v1.api.qrpay.cancel', $identifier);
        }

        $token = $access->data->access_token;
        // Payment Url Request

        $amount = $output['amount']->total_amount ? number_format($output['amount']->total_amount, 2, '.', '') : 0;

        if (PaymentGatewayConst::ENV_SANDBOX == $credentials->mode) {
            $base_url = $credentials->base_url_sandbox;
        } elseif (PaymentGatewayConst::ENV_PRODUCTION == $credentials->mode) {
            $base_url = $credentials->base_url_production;
        }


        $response = Http::withToken($token)->post($base_url . '/payment/create', [
            'amount'     => $amount,
            'currency'   => "USD",
            'return_url' => $return_url,
            'cancel_url' => $cancel_url,
            'custom'   => $identifier,
        ]);

        $statusCode = $response->getStatusCode();
        $content    = json_decode($response->getBody()->getContents());

        if ($content->type == 'error') {
            $errors = implode($content->message->error);
            throw new Exception($errors);
        }
        $data['link'] = $content->data->payment_url;
        $data['trx'] = $identifier;

        return $data;
    }
    public function getQrpayCredetials($output)
    {
        $gateway = $output['gateway'] ?? null;

        if (!$gateway) throw new Exception("Payment gateway not available");
        $client_id_sample = ['api key', 'api_key', 'client id', 'primary key'];
        $client_secret_sample = ['client_secret', 'client secret', 'secret', 'secret key', 'secret id'];
        $base_url_sandbox = ['sendbox-base-url', 'sandbox_url', 'base_url', 'base_url_sandbox', 'base url', 'base-url', 'url', 'base-url-sandbox', 'sandbox'];
        $base_url_production = ['live-base-url', 'production_url', 'base_url_production', 'base_url', 'base url', 'base-url', 'url', 'base-url-production', 'production'];


        $client_id = '';
        $outer_break = false;
        foreach ($client_id_sample as $item) {
            if ($outer_break == true) {
                break;
            }
            $modify_item = $this->qrpayPlainText($item);
            foreach ($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = $this->qrpayPlainText($label);

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
            $modify_item = $this->qrpayPlainText($item);
            foreach ($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = $this->qrpayPlainText($label);

                if ($label == $modify_item) {
                    $secret_id = $gatewayInput->value ?? "";
                    $outer_break = true;
                    break;
                }
            }
        }

        $sandbox_url = '';
        $outer_break = false;
        foreach ($base_url_sandbox as $item) {
            if ($outer_break == true) {
                break;
            }
            $modify_item = $this->qrpayPlainText($item);
            foreach ($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = $this->qrpayPlainText($label);

                if ($label == $modify_item) {
                    $sandbox_url = $gatewayInput->value ?? "";
                    $outer_break = true;
                    break;
                }
            }
        }

        $production_url = '';
        $outer_break = false;
        foreach ($base_url_production as $item) {
            if ($outer_break == true) {
                break;
            }
            $modify_item = $this->qrpayPlainText($item);
            foreach ($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = $this->qrpayPlainText($label);

                if ($label == $modify_item) {
                    $production_url = $gatewayInput->value ?? "";
                    $outer_break = true;
                    break;
                }
            }
        }


        return (object) [
            'client_id'     => $client_id,
            'client_secret' => $secret_id,
            'base_url_sandbox' => $sandbox_url,
            'base_url_production' => $production_url,
            'mode'          => $gateway->env,

        ];
    }

    public function qrpayPlainText($string)
    {
        $string = Str::lower($string);
        return preg_replace("/[^A-Za-z0-9]/", "", $string);
    }

    public function accessTokenQrpay($credentials)
    {

        if (PaymentGatewayConst::ENV_SANDBOX == $credentials->mode) {
            $base_url = $credentials->base_url_sandbox;
        } elseif (PaymentGatewayConst::ENV_PRODUCTION == $credentials->mode) {
            $base_url = $credentials->base_url_production;
        }


        $response = Http::post($base_url . '/authentication/token', [
            'client_id' => $credentials->client_id,
            'secret_id' => $credentials->client_secret,
        ]);


        $statusCode = $response->getStatusCode();
        $content = $response->getBody()->getContents();

        if ($statusCode != 200) {
            throw new Exception("Access token capture failed");
        }

        return json_decode($content);
    }

    public function qrpayJunkInsert($response)
    {
        $output = $this->output;

        $user = auth()->guard(get_auth_guard())->user();
        $creator_table = $creator_id = $wallet_table = $wallet_id = null;

        if ($user != null) {
            $creator_table = auth()->guard(get_auth_guard())->user()->getTable();
            $creator_id = auth()->guard(get_auth_guard())->user()->id;
            $wallet_table = $output['wallet']->getTable();
            $wallet_id = $output['wallet']->id;
        }

        $data = [
            'gateway'      => $output['gateway']->id,
            'currency'     => $output['currency']->id,
            'amount'       => json_decode(json_encode($output['amount']), true),
            'response'     => $response,
            'wallet_table'  => $wallet_table,
            'wallet_id'     => $wallet_id,
            'creator_table' => $creator_table,
            'creator_id'    => $creator_id,
            'creator_guard' => get_auth_guard(),
            'type' => $output['type'] ?? '',
            'data' => $output['billingTempData']->data ?? ''
        ];



        Session::put('identifier', $response);
        Session::put('output', $output);

        return TemporaryData::create([
            'type'          => PaymentGatewayConst::QRPAY,
            'identifier'    => $response,
            'data'          => $data,
        ]);
    }

    public function qrpaySuccess($output = null)
    {
        if (!$output) $output = $this->output;
        $user_request_id = $output['amount']->user_request_id;
        $user_request_data = UserRequest::where('id', $user_request_id)->first();
        $output['nanny_wallet'] = $user_request_data->nanny->nanny_wallet;
        $token = $this->output['tempData']['identifier'] ?? "";
        if (empty($token)) throw new Exception('Transaction faild. Record didn\'t saved properly. Please try again.');
        return $this->createTransactionQrpay($output);
    }

    public function createTransactionQrpay($output)
    {
        $basic_setting = BasicSettingsProvider::get();
        $user = auth()->user();
        $user_request = UserRequest::where('user_id', $user->id)->first();
        $trx_id = 'AM' . getTrxNum();

        $inserted_id = $this->insertRecordQrpay($output);
        $this->insertChargesQrpay($output, $inserted_id);
        $this->insertDeviceQrpay($output, $inserted_id);
        $this->removeTempDataQrpay($output);

        if ($this->requestIsApiUser()) {
            // logout user
            $api_user_login_guard = $this->output['api_login_guard'] ?? null;
            if ($api_user_login_guard != null) {
                auth()->guard($api_user_login_guard)->logout();
            }
        }
        if ($basic_setting->email_notification == true) {
            $user->notify(new PaymentMail($user, $output, $trx_id, $user_request));
        }
    }

    public function updateWalletBalanceQrpay($output)
    {
        $update_amount = $output['nanny_wallet']->balance + $output['amount']->requested_amount;
        $output['nanny_wallet']->update([
            'balance'   => $update_amount,
        ]);
    }

    public function insertRecordQrpay($output)
    {
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
        DB::beginTransaction();
        try {
            if (Auth::guard(get_auth_guard())->check()) {
                $user_id = auth()->guard(get_auth_guard())->user()->id;
            } else {
                $user_id = null;
            }


            // Condintion for type wise payment

            // Add money
            $trx_id = generate_unique_string("transactions", "trx_id", 16);
            $id = DB::table("transactions")->insertGetId([
                'user_id'                       => $user_id,
                'nanny_wallet_id'                => $output['nanny_wallet']->id,
                'payment_gateway_currency_id'   => $output['currency']->id,
                'type'                          => $output['type'],
                'trx_id'                        => $trx_id,
                'request_amount'                => $output['amount']->requested_amount,
                'payable'                       => $output['amount']->total_amount,
                'available_balance'             => $output['nanny_wallet']->balance + $output['amount']->requested_amount,
                'remark'                        => ucwords(remove_speacial_char($output['type'], " ")) . " With " . $output['gateway']->name,
                'details'                       => json_encode($data),
                'status'                        => 2,
                'created_at'                    => now(),
            ]);

            $this->updateWalletBalanceQrpay($output);

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

    public function insertChargesQrpay($output, $id)
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

            if (Auth::guard(get_auth_guard())->check()) {
                $user_id = auth()->guard(get_auth_guard())->user()->id;
            } else {
                $user_id = null;
            }

            //notification
            $notification_content = [
                'title'         => "Payment Successfully",
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

    public function insertDeviceQrpay($output, $id)
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

    public function removeTempDataQrpay($output)
    {
        TemporaryData::where("identifier", $output['tempData']['identifier'])->delete();
    }
}
