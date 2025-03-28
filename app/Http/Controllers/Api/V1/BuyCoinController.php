<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Models\BuyCoin;
use App\Models\UserWallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Admin\AddCoin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\TransactionSetting;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class BuyCoinController extends Controller
{
    public function buyCoinInfo()
    {
        $user = auth()->user();
        $userWallet = UserWallet::where('user_id', $user->id)->get()->map(function ($data) {
            return [
                'balance' => getAmount($data->balance, 2),
                'currency' => get_default_currency_code(),
            ];
        })->first();

        $transactions = BuyCoin::latest()->take(5)->get()->map(function ($item) {
            $statusInfo = [
                "pending" =>      1,
                "success" =>      2,
                "rejected" =>     3,
            ];

            return [
                'id' => $item->id,
                'trx_id' => $item->trx_id,
                'user_id' => $item->user_id,
                'login_vender' => $item->login_vender,
                'gateway_currency_name' => get_default_currency_code(),
                'status' => $item->status,
                'username_or_email' => $item->username_or_email,
                'coin' => $item->coin,
                'price' => getAmount($item->price, 2) . ' ' . get_default_currency_code(),
                'charge' => getAmount($item->charge, 2) . ' ' . get_default_currency_code(),
                'payable' => getAmount($item->total_amount, 2) . ' ' . get_default_currency_code(),
                'date_time' => $item->created_at,
                'status_info' => (object)$statusInfo,
                'rejection_reason' => $item->reject_reason ?? "",

            ];
        });

        $add_coins = AddCoin::latest()->take(6)->get()->map(function ($item) {

            return [
                'id' => $item->id,
                'coin' => $item->coin,
                'price' => $item->price,
            ];
        });



        $data = [
            'base_curr'    => get_default_currency_code(),
            'base_curr_rate'    => getAmount(1, 2),
            'default_image'    => "public/backend/images/default/default.webp",
            "image_path"  =>  "public/backend/images/payment-gateways",
            'userWallet'   =>   (object)$userWallet,
            'add_coins' => $add_coins,
            'transactions'   =>   $transactions,
        ];
        $message =  ['success' => ['Buy Coin Information!']];
        return ApiResponse::success($message, $data);
    }
    function buyCoinInsert(Request $request)
    {
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'login_vender' => 'required',
            'username_or_email' => 'required',
            'password' => 'required',
            'recharge' => 'required',
        ]);

        if ($validator->fails()) {
            $error =  ['error' => $validator->errors()->all()];
            return ApiResponse::validation($error);
        }
        $validated = $validator->validate();

        $userWallet = UserWallet::where('user_id', $user_id)->first();
        if (!$userWallet) {
            $error = ['error' => ['Your wallet not found']];
            return ApiResponse::error($error);
        }

        $coinPrice = $request->recharge;
        $exploded = explode("|", $coinPrice);
        $coin = $exploded[0];
        $price = $exploded[1];

        $user_balance = $userWallet->balance;
        if ($user_balance < $price) {
            $error = ['error' => ['Don\'t have enough balance']];
            return ApiResponse::error($error);
        }

        $charge = TransactionSetting::all()->first();
        $fixed_charge = $charge->fixed_charge;
        $percent_charge = ($charge->percent_charge * $price) / 100;
        $total_charge = $fixed_charge + $percent_charge;

        $buy_coin = BuyCoin::where('id', $user_id)->first();

        if ($buy_coin ? $buy_coin->status == 2 : false) {
            $user_balance = $userWallet->balance;
            $deduct_balance = $user_balance - ($total_charge + $price);
            $userWallet->update([
                'balance' => $deduct_balance
            ]);
        }
        $buy_coin = BuyCoin::latest()->take(5)->get()->map(function ($item) {
            $statusInfo = [
                "pending" =>      1,
                "success" =>      2,
                "rejected" =>     3,
            ];

            return [
                'id' => $item->id,
                'trx_id' => $item->trx_id,
                'user_id' => $item->user_id,
                'login_vender' => $item->login_vender,
                'gateway_currency_name' => get_default_currency_code(),
                'status' => $item->status,
                'username_or_email' => $item->username_or_email,
                'coin' => $item->coin,
                'price' => getAmount($item->price, 2) . ' ' . get_default_currency_code(),
                'charge' => getAmount($item->charge, 2) . ' ' . get_default_currency_code(),
                'payable' => getAmount($item->total_amount, 2) . ' ' . get_default_currency_code(),
                'date_time' => $item->created_at,
                'status_info' => (object)$statusInfo,
                'rejection_reason' => $item->reject_reason ?? "",

            ];
        });

        try {
            BuyCoin::create([
                'login_vender' => $validated['login_vender'],
                'username_or_email' => $validated['username_or_email'],
                'password' => $validated['password'],
                'coin' => $coin,
                'price' => $price,
                'charge' => $total_charge,
                'trx_id' => generate_unique_string('transactions', 'trx_id', 16),
                'user_id' => $user_id,
                'total_amount' => $total_charge + $price,
            ]);
        } catch (Exception $e) {
            $error = ['error' => ['Somthing was wrong!']];
            return ApiResponse::error($error);
        }

        $message =  ['success' => ['Buy Coin Inserted Successfully!']];
        return ApiResponse::success($message, $buy_coin);
    }
}
