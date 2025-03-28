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
use App\Http\Helpers\Api\Helpers as ApiResponse;
use App\Notifications\User\AddMoney\ApprovedMail;
use App\Notifications\User\SitterHub\PaymentMail;

trait Stripe
{

    public function stripeInit($output = null)
    {

        $basic_settings = BasicSettingsProvider::get();
        if (!$output) $output = $this->output;
        $gatewayAlias = $output['gateway']['alias'];
        $identifier = generate_unique_string("transactions", "trx_id", 16);
        $credentials = $this->getStripeCredetials($output);
        $amount = $output['amount']->total_amount ? number_format($output['amount']->total_amount, 2, '.', '') : 0;
        $currency = $output['currency']['currency_code'] ?? "USD";
        if (auth()->guard(get_auth_guard())->check()) {
            $user = auth()->guard(get_auth_guard())->user();
            $user_email = $user->email;
            $user_phone = $user->full_mobile ?? '';
            $user_name = $user->firstname . ' ' . $user->lastname ?? '';
        }
        $return_url = route('user.add.money.stripe.payment.success', $identifier);
        // Enter the details of the payment
        $data = [
            'payment_options' => 'card',
            'amount'          => $amount,
            'email'           => $user_email,
            'tx_ref'          => $identifier,
            'currency'        => $currency,
            'redirect_url'    => $return_url,
            'customer'        => [
                'email'        => $user_email,
                "phone_number" => $user_phone,
                "name"         => $user_name
            ],
            "customizations" => [
                "title"       => "Payment",
                "description" => dateFormat('d M Y', Carbon::now()),
            ]
        ];
        //start stripe pay link
        $stripe = new \Stripe\StripeClient($credentials->secret_key);
        //create product for Product Id
        try {
            $product_id = $stripe->products->create([
                'name' => 'Payment( ' . $basic_settings->site_name . ' )',
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        //create price for Price Id
        try {
            $price_id = $stripe->prices->create([
                'currency' =>  $currency,
                'unit_amount' => $amount * 100,
                'product' => $product_id->id ?? ""
            ]);
        } catch (Exception $e) {
            throw new Exception("Something Is Wrong, Please Contact With Owner");
        }
        //create payment live links
        try {
            $payment_link = $stripe->paymentLinks->create([
                'line_items' => [
                    [
                        'price' => $price_id->id,
                        'quantity' => 1,
                    ],
                ],
                'after_completion' => [
                    'type' => 'redirect',
                    'redirect' => ['url' => $return_url],
                ],


            ]);
        } catch (Exception $e) {
            throw new Exception("Something Is Wrong, Please Contact With Owner");
        }

        $this->stripeJunkInsert($data);

        return redirect($payment_link->url . "?prefilled_email=" . @$user->email);
    }

    public function getStripeCredetials($output)
    {
        $gateway = $output['gateway'] ?? null;
        if (!$gateway) throw new Exception("Payment gateway not available");

        $client_id_sample = ['publishable_key', 'publishable key', 'publishable-key'];
        $client_secret_sample = ['secret id', 'secret-id', 'secret_id', 'secret_key', 'secret key', 'secret-key'];

        $client_id = '';
        $outer_break = false;

        foreach ($client_id_sample as $item) {
            if ($outer_break == true) {
                break;
            }

            $modify_item = $this->stripePlainText($item);

            foreach ($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = $this->stripePlainText($label);

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
            $modify_item = $this->stripePlainText($item);
            foreach ($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = $this->stripePlainText($label);

                if ($label == $modify_item) {
                    $secret_id = $gatewayInput->value ?? "";
                    $outer_break = true;
                    break;
                }
            }
        }

        return (object) [
            'publish_key'     => $client_id,
            'secret_key' => $secret_id,

        ];
    }

    public function stripePlainText($string)
    {
        $string = Str::lower($string);
        return preg_replace("/[^A-Za-z0-9]/", "", $string);
    }
    public function stripeJunkInsert($response)
    {
        $output = $this->output;
        $user = auth()->guard(get_auth_guard())->user();
        $creator_table = $creator_id = $wallet_table = $wallet_id = null;


        $creator_table = auth()->guard(get_auth_guard())->user()->getTable();
        $creator_id = auth()->guard(get_auth_guard())->user()->id;
        $wallet_table = $output['wallet']->getTable();
        $wallet_id = $output['wallet']->id;


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
            'type' => $output['type'],
        ];

        return TemporaryData::create([
            'type'          => PaymentGatewayConst::STRIPE,
            'identifier'    => $response['tx_ref'],
            'data'          => $data,
        ]);
    }

    public function createTransactionStripe($output)
    {
        $basic_setting = BasicSettingsProvider::get();
        $user = auth()->user();
        $user_request = UserRequest::where('user_id', $user->id)->first();
        $trx_id = 'AM' . getTrxNum();

        $inserted_id = $this->insertRecordStripe($output);

        $this->insertChargesStripe($output, $inserted_id);
        $this->insertDeviceStripe($output, $inserted_id);
        $this->removeTempDataStripe($output);

        if ($basic_setting->email_notification == true) {
            $user->notify(new PaymentMail($user, $output, $trx_id, $user_request));
        }
    }

    public function insertRecordStripe($output)
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

        DB::beginTransaction();
        try {
            $id = DB::table("transactions")->insertGetId([
                'user_id'                       => $user_id,
                'nanny_id'                       => $user_request->nanny_id,
                'nanny_wallet_id'                => $output['nanny_wallet']->id,
                'payment_gateway_currency_id'   => $output['currency']->id,
                'type'                          =>  "ADD-MONEY",
                'trx_id'                        => $trx_id,
                'request_amount'                => $user_request->total,
                'payable'                       => $user_request->payable,
                'available_balance'             => $output['nanny_wallet']->balance + $output['amount']->requested_amount,
                'remark'                        => ucwords(remove_speacial_char(PaymentGatewayConst::TYPEADDMONEY, " ")) . " With " . $output['gateway']->name,
                'details'                       => json_encode($data),
                'status'                        => true,
                'attribute'                      => PaymentGatewayConst::SEND,
                'created_at'                    => now(),
            ]);
            $this->updateWalletBalanceStripe($output);

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

    public function updateWalletBalanceStripe($output)
    {
        $update_amount = $output['nanny_wallet']->balance + $output['amount']->requested_amount;

        $output['nanny_wallet']->update([
            'balance'   => $update_amount,
        ]);
    }

    public function insertChargesStripe($output, $id)
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

    public function insertDeviceStripe($output, $id)
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

    public function removeTempDataStripe($output)
    {
        $token = session()->get('identifier');
        TemporaryData::where("identifier", $token)->delete();
    }

    //for api
    public function stripeInitApi($output = null)
    {
        $basic_settings = BasicSettingsProvider::get();
        if (!$output) $output = $this->output;
        $credentials = $this->getStripeCredetials($output);
        $identifier = generate_unique_string("transactions", "trx_id", 16);
        $amount = $output['amount']->total_amount ? number_format($output['amount']->total_amount, 2, '.', '') : 0;
        $currency = $output['currency']['currency_code'] ?? "USD";


        if (auth()->guard(get_auth_guard())->check()) {
            $user = auth()->guard(get_auth_guard())->user();
            $user_email = $user->email;
            $user_phone = $user->full_mobile ?? '';
            $user_name = $user->firstname . ' ' . $user->lastname ?? '';
        }

        $return_url = route('api.v1.user.stripe.payment.success', $identifier . "?r-source=" . PaymentGatewayConst::APP);


        // Enter the details of the payment
        $data = [
            'payment_options' => 'card',
            'amount'          => $amount,
            'email'           => $user_email,
            'tx_ref'          => $identifier,
            'currency'        =>  $currency,
            'redirect_url'    => $return_url,
            'customer'        => [
                'email'        => $user_email,
                "phone_number" => $user_phone,
                "name"         => $user_name
            ],
            "customizations" => [
                "title"       => "Payment",
                "description" => dateFormat('d M Y', Carbon::now()),
            ]
        ];

        //start stripe pay link
        $stripe = new \Stripe\StripeClient($credentials->secret_key);

        //create product for Product Id
        try {
            $product_id = $stripe->products->create([
                'name' => 'Payment( ' . $basic_settings->site_name . ' )',
            ]);
        } catch (Exception $e) {
            $error = ['error' => [$e->getMessage()]];
            return ApiResponse::error($error);
        }
        //create price for Price Id
        try {
            $price_id = $stripe->prices->create([
                'currency' =>  $currency,
                'unit_amount' => $amount * 100,
                'product' => $product_id->id ?? ""
            ]);
        } catch (Exception $e) {
            $error = ['error' => ["Something Is Wrong, Please Contact With Owner"]];
            return ApiResponse::error($error);
        }
        //create payment live links
        try {
            $payment_link = $stripe->paymentLinks->create([
                'line_items' => [
                    [
                        'price' => $price_id->id,
                        'quantity' => 1,
                    ],
                ],
                'after_completion' => [
                    'type' => 'redirect',
                    'redirect' => ['url' => $return_url],
                ],
            ]);
        } catch (Exception $e) {
            $error = ['error' => ["Something Is Wrong, Please Contact With Owner"]];
            return ApiResponse::error($error);
        }
        $data['link'] =  $payment_link->url;
        $data['trx'] =  $identifier;

        $this->stripeJunkInsert($data);
        return $data;
    }

    public function stripeSuccess($output = null)
    {

        if (!$output) $output = $this->output;
        $user_request_id = $output['amount']->user_request_id;
        $user_request_data = UserRequest::where('id', $user_request_id)->first();
        $output['nanny_wallet'] = $user_request_data->nanny->nanny_wallet;
        $token = $this->output['tempData']['identifier'] ?? "";
        if (empty($token)) throw new Exception('Transaction failed. Record didn\'t saved properly. Please try again.');
        $trx_id = generateTrxString('transactions', 'trx_id', 'AM', 8);
        return $this->createTransactionStripe($output, $trx_id);
    }
}
