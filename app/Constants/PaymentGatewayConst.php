<?php

namespace App\Constants;

use App\Models\UserWallet;
use Illuminate\Support\Str;

class PaymentGatewayConst
{

    const AUTOMATIC = "AUTOMATIC";
    const MANUAL    = "MANUAL";
    const ADDMONEY  = "Add Money";
    const MONEYOUT  = "Money Out";
    const SELLCOIN  = "Sell Coin";
    const NANNYPAYMENT  = "Nanny Payment";
    const ACTIVE    =  true;

    const TYPETOPUP      = "TOP-UP";
    const TYPEADDMONEY      = "ADD-MONEY";
    const TYPEMONEYOUT      = "MONEY-OUT";
    const TYPEWITHDRAW      = "WITHDRAW";
    const TYPECOMMISSION    = "COMMISSION";
    const TYPEBONUS         = "BONUS";
    const TYPETRANSFERMONEY = "TRANSFER-MONEY";
    const TYPEMONEYEXCHANGE = "MONEY-EXCHANGE";
    const TYPEADDSUBTRACTBALANCE = "ADD-SUBTRACT-BALANCE";
    const TYPESELLCOIN      = "SELL-COIN";
    const TYPEBUYCOIN      = "BUY-COIN";
    const TYPENANNYPAYMENT      = "NANNY-PAYMENT";

    const STATUSSUCCESS     = 1;
    const STATUSPENDING     = 2;
    const STATUSHOLD        = 3;
    const STATUSREJECTED    = 4;

    //Status
    const REVIEW_PAYMENT = 1;
    const PENDING = 2;
    const CONFIRM_PAYMENT = 3;
    const ON_HOLD = 4;
    const SETTLED = 5;
    const COMPLETED = 6;
    const CANCELED = 7;
    const FAILED = 8;
    const REFUNDED = 9;
    const DELAYED = 10;
    const REJECTED = 11;

    const PAYPAL = 'paypal';
    const STRIPE = 'stripe';
    const MANUA_GATEWAY = 'manual';
    const FLUTTER_WAVE = 'flutterwave';
    const RAZORPAY = 'razorpay';
    const SSLCOMMERZ = 'sslcommerz';
    const QRPAY = 'qrpay';
    const PAYSTACK  = "paystack";

    const SEND = "SEND";
    const RECEIVED = "RECEIVED";

    const ENV_SANDBOX       = "SANDBOX";
    const ENV_PRODUCTION    = "PRODUCTION";

    public static function add_money_slug()
    {
        return Str::slug(self::ADDMONEY);
    }


    public static function money_out_slug()
    {
        return Str::slug(self::MONEYOUT);
    }
    public static function sell_coin_slug()
    {
        return Str::slug(self::SELLCOIN);
    }
    public static function nanny_payment_slug()
    {
        return Str::slug(self::NANNYPAYMENT);
    }

    const REDIRECT_USING_HTML_FORM = "REDIRECT_USING_HTML_FORM";
    const CALLBACK_HANDLE_INTERNAL  = "CALLBACK_HANDLE_INTERNAL";

    public static function register($alias = null)
    {
        $gateway_alias  = [
            self::PAYPAL => "paypalInit",
            self::STRIPE => "stripeInit",
            self::MANUA_GATEWAY => "manualInit",
            self::FLUTTER_WAVE => 'flutterwaveInit',
            self::RAZORPAY => 'razorInit',
            self::SSLCOMMERZ => 'sslcommerzInit',
            self::QRPAY => "qrpayInit",
            self::PAYSTACK      => 'paystackInit'

        ];

        if ($alias == null) {
            return $gateway_alias;
        }

        if (array_key_exists($alias, $gateway_alias)) {
            return $gateway_alias[$alias];
        }
        return "init";
    }
    const APP       = "APP";


    public static function registerRedirection()
    {

        $addmoney = [
            'web'       => [
                'return_url'    => 'user.add.money.payment.global.success',
                'cancel_url'    => 'user.add.money.payment.global.cancel',
                'callback_url'  => 'user.add.money.payment.callback',
                'btn_pay'       => 'user.add.money.payment.btn.pay',
            ],
            'api'       => [
                'return_url'    => 'api.v1.api.user.add.money.payment.global.success',
                'cancel_url'    => 'api.v1.api.user.add.money.payment.global.cancel',
                'callback_url'  => 'user.add.money.payment.callback',
                'btn_pay'       => 'api.v1.api.user.add.money.payment.btn.pay',
            ],
        ];

        return $data = [
            self::TYPEADDMONEY => $addmoney
        ];
    }

    public static function apiAuthenticateGuard()
    {
        return [
            'api'   => 'web',
        ];
    }

    public static function registerWallet()
    {
        return [
            'web'       => UserWallet::class,
            'api'       => UserWallet::class,
        ];
    }

    public static function registerGatewayRecognization()
    {
        return [

            'isRazorpay'        => self::RAZORPAY,
            'isPayStack'        => self::PAYSTACK,

        ];
    }
}
