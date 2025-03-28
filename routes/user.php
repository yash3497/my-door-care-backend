<?php

use App\Http\Controllers\User\AddBabyPetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\AddMoneyController;
use App\Http\Controllers\User\BuyCoinController;
use App\Http\Controllers\User\WithdrawController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\NannyListController;
use App\Http\Controllers\User\SecurityController;
use App\Http\Controllers\User\ServiceTrackingController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\SupportTicketController;
use App\Http\Controllers\User\UserRequestController;

Route::prefix("user")->name("user.")->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('dashboard');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::controller(AddBabyPetController::class)->prefix('add-baby-pet')->name('add.baby.pet.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('delete', 'delete')->name('delete');
    });
    //Nanny List
    Route::controller(NannyListController::class)->prefix('nanny-list')->name('nanny.list.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('nanny/details/{id}', 'nannyDetails')->name('details');
        Route::get('service/request/{id}', 'serviceRequest')->name('service.request');
    });
    Route::controller(UserRequestController::class)->prefix('user-request')->name('user_request.')->group(function () {
        Route::post('user-request/submit/{id}', 'userRequestSubmit')->name('submit');
        Route::post('rating', 'rating')->name('rating');
    });
    //Service tracking
    Route::controller(ServiceTrackingController::class)->prefix('service-tracking')->name('service.tracking.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('cancel/{id}', 'cancel')->name('cancel');
    });

    //user profile
    Route::controller(ProfileController::class)->prefix("profile")->name("profile.")->middleware('app.mode')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/password/change', 'passwordChangeForm')->name('password.change.form');
        Route::put('password/update', 'passwordUpdate')->name('password.update');
        Route::put('update', 'update')->name('update');
        Route::post('account/delete/{id}', 'accountDelete')->name('account.delete');
    });

    //add money
    Route::controller(AddMoneyController::class)->prefix("add-money")->name("add.money.")->group(function () {
        Route::get('/', 'index')->name("index");
        Route::post('submit', 'submit')->name('submit');

        // Controll AJAX Resuest
        Route::post("xml/currencies", "getCurrenciesXml")->name("xml.currencies");
        Route::get('payment/{gateway}', 'payment')->name('payment');
        //manual gateway
        Route::get('manual/payment', 'manualPayment')->name('manual.payment');
        Route::post('manual/payment/confirmed', 'manualPaymentConfirmed')->name('manual.payment.confirmed');
        //Paypal payment confirm
        Route::get('success/response/paypal/{gateway}', 'success')->name('payment.success');
        Route::get("cancel/response/paypal/{gateway}", 'cancel')->name('payment.cancel');
        //stript payment confirm
        Route::get('stripe/payment/success/{trx}', 'stripePaymentSuccess')->name('stripe.payment.success');
        //Flutterwave
        Route::get('flutterwave/callback', 'flutterwaveCallback')->name('flutterwave.callback');
        //Razorpay
        //global
        Route::post("callback/response/{gateway}", 'callback')->name('payment.callback')->withoutMiddleware(['web', 'auth', 'verification.guard', 'user.google.two.factor']);
        //redirect with Btn Pay
        Route::get('redirect/btn/checkout/{gateway}', 'redirectBtnPay')->name('payment.btn.pay')->withoutMiddleware(['auth', 'verification.guard', 'user.google.two.factor']);

        Route::get('success/response/{gateway}', 'successGlobal')->name('payment.global.success');
        Route::get("cancel/response/{gateway}", 'cancelGlobal')->name('payment.global.cancel');
        // POST Route For Unauthenticated Request
        Route::post('success/response/{gateway}', 'postSuccess')->name('payment.global.success')->withoutMiddleware(['auth', 'verification.guard', 'user.google.two.factor']);
        Route::post('cancel/response/{gateway}', 'postCancel')->name('payment.global.cancel')->withoutMiddleware(['auth', 'verification.guard', 'user.google.two.factor']);
        Route::get('qrpay/callback', 'qrpayCallback')->name('qrpay.callback');
        Route::get('qrpay/cancel/{trx_id}', 'qrpayCancel')->name('qrpay.cancel');
    });
    //withdraw
    Route::controller(WithdrawController::class)->prefix("withdraw")->name('withdraw.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('submit', 'submit')->name('submit');
        Route::get('instruction/{token}', 'instruction')->name('instruction');
        Route::post('instruction/submit/{token}', 'instructionSubmit')->name('instruction.submit');
    });

    // Buy Coin
    Route::controller(BuyCoinController::class)->prefix('buy-coin')->name('buy.coin.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('preview', 'preview')->name('preview');
        Route::post('submit', 'submit')->name('submit');
        Route::post('previewSubmit', 'previewSubmit')->name('previewSubmit');
    });

    //transactions
    Route::controller(TransactionController::class)->prefix("transactions")->name("transactions.")->group(function () {
        Route::get('/{slug?}', 'index')->name('index')->whereIn('slug', ['add-money', 'money-out', 'sell-coin', 'withdraw']);
        Route::get('/buy-coin', 'buyCoinIndex')->name('buy.coin.index');
        Route::post('search', 'search')->name('search');
    });
    //wallet
    Route::controller(WalletController::class)->prefix("wallets")->name("wallets.")->group(function () {
        Route::get("/", "index")->name("index");
        Route::post("balance", "balance")->name("balance");
    });

    //support ticket
    Route::controller(SupportTicketController::class)->prefix("prefix")->name("support.ticket.")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('conversation/{encrypt_id}', 'conversation')->name('conversation');
        Route::post('message/send', 'messageSend')->name('messaage.send');
    });


    //google-2fa
    Route::controller(SecurityController::class)->prefix('security')->name('security.')->group(function () {
        Route::get('google/2fa', 'google2FA')->name('google.2fa');
        Route::post('google/2fa/status/update', 'google2FAStatusUpdate')->name('google.2fa.status.update')->middleware('app.mode');
    });
});
