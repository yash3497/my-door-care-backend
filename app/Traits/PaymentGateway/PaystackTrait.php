<?php

namespace App\Traits\PaymentGateway;

use Exception;
use App\Models\Campaign;
use App\Models\Transaction;
use App\Models\UserRequest;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use App\Models\TemporaryData;
use Illuminate\Support\Carbon;
use App\Models\UserNotification;
use App\Traits\TransactionAgent;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\BasicSettings;
use App\Constants\NotificationConst;
use App\Http\Helpers\PaymentGateway;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Constants\PaymentGatewayConst;
use App\Traits\PayLink\TransactionTrait;
use App\Http\Helpers\PushNotificationHelper;
use App\Models\Admin\PaymentGatewayCurrency;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Notification;
use App\Providers\Admin\BasicSettingsProvider;
use App\Notifications\User\AddMoney\ApprovedMail;
use App\Notifications\User\SitterHub\PaymentMail;
use App\Notifications\User\Donation\DonationSuccessMail;
use App\Models\Admin\PaymentGateway as PaymentGatewayModel;
use App\Notifications\User\Donation\GuestDonationSuccessMail;

trait PaystackTrait
{
    // use TransactionAgent,TransactionTrait;
    public function paystackInit($output = null)
    {
        if (!$output) $output = $this->output;
        $credentials = $this->getPaystackCredentials($output);

        return $this->createPayStackCheckout($credentials, $output);
    }
    public function createPayStackCheckout(object $credentials, array $output)
    {

        $amount         = get_amount($output['amount']->total_amount);
        $currency_code  = $output['currency']->currency_code;

        $user = auth()->guard(get_auth_guard())->user();
        $user_email = $user->email;

        $temp_record_token = generate_unique_string('temporary_datas', 'identifier', 60);
        $this->setUrlParams("token=" . $temp_record_token);
        $redirection = $this->getRedirection();
        $url_parameter = $this->getUrlParams();


        $url = "https://api.paystack.co/transaction/initialize";

        $fields             = [
            'email'         => $user_email,
            'amount'        => get_amount($amount) * 100,
            'currency'      => $currency_code,
            'callback_url'  => $this->setGatewayRoute($redirection['return_url'], PaymentGatewayConst::PAYSTACK, $url_parameter),
            'reference'     => $temp_record_token,
        ];

        $response = Http::withHeaders([
            'Authorization' => "Bearer $credentials->secret_key",
            'Cache-Control' => 'no-cache'
        ])->post($url, $fields)->throw(function (Response $response, RequestException $e) {
            $message = $response->json()['message'] ?? 'Something went wrong! Please try again';
            throw new Exception($message);
        })->json();

        if ($response['status'] == true) {
            $this->paystackJunkInsert($response, $temp_record_token);
            $redirect_url = $response['data']['authorization_url'] ?? null;

            if (!$redirect_url) throw new Exception("Something went wrong! Please try again");

            if (request()->expectsJson()) { // API Response
                $this->output['temp_identifier']        = $temp_record_token;
                $this->output['redirection_response']   = $response;
                $this->output['redirect_links']         = [];
                $this->output['redirect_url']           = $redirect_url;
                return $this->get();
            }

            return redirect()->away($redirect_url);
        }

        throw new Exception($response['message'] ?? 'Something went wrong! Please try again');
    }

    public function getPayStackCredentials($output)
    {
        $gateway = $output['gateway'] ?? null;
        if (!$gateway) throw new Exception(__("Payment gateway not available"));

        $public_key_sample = ['public_key', 'Public Key', 'public-key'];
        $secret_key_sample = ['secret_key', 'Secret Key', 'secret-key'];

        $public_key    = PaymentGateway::getValueFromGatewayCredentials($gateway, $public_key_sample);
        $secret_key    = PaymentGateway::getValueFromGatewayCredentials($gateway, $secret_key_sample);

        $mode = $gateway->env;

        $gateway_register_mode = [
            PaymentGatewayConst::ENV_SANDBOX => PaymentGatewayConst::ENV_SANDBOX,
            PaymentGatewayConst::ENV_PRODUCTION => PaymentGatewayConst::ENV_PRODUCTION,
        ];

        if (array_key_exists($mode, $gateway_register_mode)) {
            $mode = $gateway_register_mode[$mode];
        } else {
            $mode = PaymentGatewayConst::ENV_SANDBOX;
        }

        $credentials = (object) [
            'public_key'                    => $public_key,
            'secret_key'                    => $secret_key,
            'mode'                          => $mode
        ];

        return $credentials;
    }


    public function paystackJunkInsert($response, $temp_identifier)
    {
        $output = $this->output;


        $data = [
            'gateway'       => $output['gateway']->id,
            'currency'      => $output['currency']->id,
            'amount'        => json_decode(json_encode($output['amount']), true),
            'response'      => $response,
            'wallet_table'  => $output['wallet']->getTable(),
            'wallet_id'     => $output['wallet']->id,
            'creator_table' => auth()->guard(get_auth_guard())->user()->getTable(),
            'creator_id'    => auth()->guard(get_auth_guard())->user()->id,
            'creator_guard' => get_auth_guard(),
        ];


        return TemporaryData::create([
            'type'          => PaymentGatewayConst::PAYSTACK,
            'identifier'    => $temp_identifier,
            'data'          => $data,
        ]);
    }


    public function paystackSuccess($output)
    {

        $temp_data = $output['tempData'];
        $user_request_id = $output['amount']->user_request_id;
        $user_request_data = UserRequest::where('id', $user_request_id)->first();
        $output['nanny_wallet'] = $user_request_data->nanny->nanny_wallet;

        // verify payStack transaction
        $response_data  = $temp_data['data']->callback_data;
        $reference      = $response_data->reference;

        $credentials    = $this->getPayStackCredentials($output);
        $secret_key     = $credentials->secret_key;

        $verify_url = "https://api.paystack.co/transaction/verify/" . $reference;

        $response = Http::withHeaders([
            "Authorization"     => "Bearer $secret_key",
            "Cache-Control"     => "no-cache",
        ])->get($verify_url)->throw(function (Response $response, RequestException $e) {
            $message = $response->json()['message'] ?? 'Something went wrong! Please try again';
            throw new Exception($message);
        })->json();

        $status = $response['status'] ?? false;
        if ($status != true) {
            $transaction_status = PaymentGatewayConst::STATUSREJECTED;
        } else {
            if ($response['data']['status'] == "success") {
                $transaction_status = PaymentGatewayConst::STATUSSUCCESS;
            } else {
                $transaction_status = PaymentGatewayConst::STATUSPENDING;
            }
        }

        $output['capture']      = $response;
        $output['callback_ref'] = $response['data']['reference']; // it's also temporary identifier

        if (!$this->searchWithReferenceInTransaction($output['callback_ref'])) {
            try {
                $this->createTransactionPaystack($output, $transaction_status, false);
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }

    public function createTransactionPaystack($output, $status, $temp_remove = true)
    {
        $basic_setting = BasicSettings::first();

        if ($this->predefined_user) {
            $user = $this->predefined_user;
        } else {
            $user = auth()->guard(get_auth_guard())->user();
        }
        $user_request = UserRequest::where('user_id', $user->id)->first();
        $trx_id = 'AM' . getTrxNum();
        $inserted_id = $this->insertRecordPaystack($output, $trx_id, $status);
        $this->insertChargesPaystack($output, $inserted_id);
        // $this->adminNotification($trx_id,$output,$status);
        $this->insertDevicePaystack($output, $inserted_id);

        if ($temp_remove) $this->removeTempDataPaystack($output);

        if ($this->requestIsApiUser()) {
            // logout user
            $api_user_login_guard = $this->output['api_login_guard'] ?? null;
            if ($api_user_login_guard != null) {
                auth()->guard($api_user_login_guard)->logout();
            }
        }
        try {
            if ($basic_setting->email_notification == true) {
                $user->notify(new PaymentMail($user, $output, $trx_id, $user_request));
            }
        } catch (Exception $e) {
        }
    }



    public function insertRecordPaystack($output, $trx_id, $status)
    {
        $trx_id = $trx_id;
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
            if ($this->predefined_user) {
                $user = $this->predefined_user;
            } else {
                $user = auth()->guard(get_auth_guard())->user();
            }

            $id = DB::table("transactions")->insertGetId([
                'user_id'                       => $user->id,
                'nanny_id'                      => $user_request->nanny_id,
                'nanny_wallet_id'               => $user_request->nanny->nanny_wallet->id,
                'payment_gateway_currency_id'   => $output['currency']->id,
                'type'                          => $output['type'],
                'trx_id'                        => $trx_id,
                'request_amount'                => $output['amount']->requested_amount,
                'payable'                       => $output['amount']->total_amount,
                'available_balance'             => $output['nanny_wallet']->balance + $output['amount']->requested_amount,
                'remark'                        => ucwords(remove_speacial_char(PaymentGatewayConst::TYPEADDMONEY, " ")) . " With " . $output['gateway']->name,
                'details'                       => json_encode(['gateway_response' => $output['capture'], 'user_request' => $data]),
                'status'                        => $status,
                'callback_ref'                  => $output['callback_ref'] ?? null,
                'attribute'                     => PaymentGatewayConst::SEND,
                'created_at'                    => now(),
            ]);
            if ($status === PaymentGatewayConst::STATUSSUCCESS) {
                $this->updateWalletBalancePaystack($output);

                $user_request->update([
                    'status' => 5
                ]);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(__("Something went wrong! Please try again."));
        }
        return $id;
    }

    public function updateWalletBalancePaystack($output)
    {
        $update_amount = $output['nanny_wallet']->balance + $output['amount']->requested_amount;

        $output['nanny_wallet']->update([
            'balance'   => $update_amount,
        ]);
    }

    public function insertChargesPaystack($output, $id)
    {
        if ($this->predefined_user) {
            $user = $this->predefined_user;
        } else {
            $user = auth()->guard(get_auth_guard())->user();
        }
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
                'type'      => NotificationConst::USER_PAYMENT,
                'user_id'  =>  $user->id,
                'message'   => $notification_content,
            ]);


            //Push Notifications
            try {
                // (new PushNotificationHelper())->prepare([$user->id],[
                //     'title' => $notification_content['title'],
                //     'desc'  => $notification_content['message'],
                //     'user_type' => 'user',
                // ])->send();
            } catch (Exception $e) {
            }
        } catch (Exception $e) {
            logger('error', [$e->getMessage()]);
            DB::rollBack();
            throw new Exception(__("Something went wrong! Please try again."));
        }
    }

    public function insertDevicePaystack($output, $id)
    {
        $client_ip = request()->ip() ?? false;
        $location = geoip()->getLocation($client_ip);
        $agent = new Agent();

        // $mac = exec('getmac');
        // $mac = explode(" ",$mac);
        // $mac = array_shift($mac);
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
            throw new Exception(__("Something went wrong! Please try again."));
        }
    }

    public function removeTempDataPaystack($output)
    {
        TemporaryData::where("identifier", $output['tempData']['identifier'])->delete();
    }
    public function isPayStack($gateway)
    {
        $search_keyword = ['Paystack', 'paystack', 'payStack', 'pay-stack', 'paystack gateway', 'paystack payment gateway'];
        $gateway_name = $gateway->name;

        $search_text = Str::lower($gateway_name);
        $search_text = preg_replace("/[^A-Za-z0-9]/", "", $search_text);
        foreach ($search_keyword as $keyword) {
            $keyword = Str::lower($keyword);
            $keyword = preg_replace("/[^A-Za-z0-9]/", "", $keyword);
            if ($keyword == $search_text) {
                return true;
                break;
            }
        }
        return false;
    }

    /**
     * paystack webhook response
     * @param array $response_data
     * @param \App\Models\Admin\PaymentGateway $gateway
     */
    public function paystackCallbackResponse(array $response_data, PaymentGatewayModel $gateway)
    {
        $output = $this->output;

        $event_type = $response_data['event'] ?? "";

        if ($event_type == "charge.success") {
            $reference = $response_data['data']['reference'];

            // verify signature START -----------------------------
            $credentials = $this->getPayStackCredentials(['gateway' => $gateway]);
            $secret_key = $credentials->secret_key;

            $hash = hash_hmac('sha512', request()->getContent(), $secret_key);

            if ($hash != request()->header('x-paystack-signature')) {
                return false;
            }
            // verify signature END -----------------------------

            // temp data
            $temp_data = TemporaryData::where('identifier', $reference)->first();

            // if transaction is already exists need to update status, balance & response data
            $transaction = Transaction::where('callback_ref', $reference)->first();

            $status = PaymentGatewayConst::STATUSSUCCESS;

            if ($temp_data) {
                $gateway_currency_id = $temp_data->data->currency ?? null;
                $gateway_currency = PaymentGatewayCurrency::find($gateway_currency_id);
                if ($gateway_currency) {

                    $requested_amount = $temp_data['data']->amount->requested_amount ?? 0;
                    $user_request_id = $temp_data['data']->amount->user_request_id;
                    $user_request_data = UserRequest::where('id', $user_request_id)->first();
                    $this->output['nanny_wallet'] = $user_request_data->nanny->nanny_wallet;
                    $validator_data = [
                        $this->currency_input_name  => $gateway_currency->alias,
                        $this->amount_input         => $requested_amount,
                        $this->user_request_id      => $temp_data['data']->amount->user_request_id
                    ];

                    $get_wallet_model = PaymentGatewayConst::registerWallet()[$temp_data->data->creator_guard];
                    $user_wallet = $get_wallet_model::find($temp_data->data->wallet_id);
                    $this->predefined_user_wallet = $user_wallet;
                    $this->predefined_guard = $user_wallet->user->modelGuardName();
                    $this->predefined_user = $user_wallet->user;

                    $this->output['tempData'] = $temp_data;
                }

                $this->request_data = $validator_data;
                $this->gateway();
            }

            $output                     = $this->output;
            $output['callback_ref']     = $reference;
            $output['capture']          = $response_data;

            if ($transaction && $transaction->status != PaymentGatewayConst::STATUSSUCCESS) {

                $update_data                        = json_decode(json_encode($transaction->details), true);
                $update_data['gateway_response']    = $response_data;

                // update information
                $transaction->update([
                    'status'    => $status,
                    'details'   => $update_data
                ]);

                // update balance
                $this->updateWalletBalancePaystack($output);
            }

            if (!$transaction) {
                // create new transaction with success
                $this->createTransactionPaystack($output, $status, false);
            }
        }
    }
    //for api
    public function paystackInitApi($output = null)
    {

        if (!$output) $output = $this->output;
        $credentials = $this->getPaystackCredentials($output);

        return $this->createPayStackCheckout($credentials, $output);
    }


}
