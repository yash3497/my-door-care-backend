<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\AddMoneyController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\AppSettingsController;
use App\Http\Controllers\Api\V1\User\SecurityController;
use App\Http\Controllers\Api\V1\User\NannyListController;
use App\Http\Controllers\Api\V1\User\AddBabyPetController;
use App\Http\Controllers\Api\V1\User\UserRequestController;
use App\Http\Controllers\Api\V1\Auth\AuthorizationController;
use App\Http\Controllers\Api\V1\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\V1\User\ServiceTrakingController;
use App\Http\Controllers\Api\V1\User\UserNotificationController;

Route::name('api.v1.')->group(function () {


    Route::controller(AddMoneyController::class)->prefix("add-money")->group(function () {
        Route::get('/flutterwave/callback', 'flutterwaveCallback')->name('api.flutterwave.callback');
        //razor api create payment link
        // Razor
        //redirect with Btn Pay
        Route::get('redirect/btn/checkout/{gateway}', 'redirectBtnPay')->name('api.user.add.money.payment.btn.pay')->withoutMiddleware(['auth:api', 'auth.api', 'CheckStatusApiUser']);

        // Global Gateway Response Routes
        Route::get('success/response/{gateway}', 'successGlobal')->withoutMiddleware(['auth:api', 'auth.api', 'CheckStatusApiUser'])->name("api.user.add.money.payment.global.success");
        Route::get("cancel/response/{gateway}", 'cancelGlobal')->withoutMiddleware(['auth:api', 'auth.api', 'CheckStatusApiUser'])->name("api.user.add.money.payment.global.cancel");

        // POST Route For Unauthenticated Request
        Route::post('success/response/{gateway}', 'postSuccess')->name('api.user.add.money.payment.global.success')->withoutMiddleware(['auth:api', 'auth.api', 'CheckStatusApiUser']);
        Route::post('cancel/response/{gateway}', 'postCancel')->name('api.user.add.money.payment.global.cancel')->withoutMiddleware(['auth:api', 'auth.api', 'CheckStatusApiUser']);


        // Qrpay gateway
        Route::get('qrpay/callback', 'qrpayCallback')->name('api.qrpay.callback');
        Route::get('qrpay/cancel/{trx_id}', 'qrpayCancel')->name('api.qrpay.cancel');
    });


    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {

        Route::controller(AppSettingsController::class)->group(function () {
            Route::get('basic/settings', 'basicSettings');
            Route::get('languages', 'languages')->withoutMiddleware(['system.maintenance.api']);
        });

        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        Route::group(['prefix' => 'forgot/password'], function () {
            Route::post('send/otp', [ForgotPasswordController::class, 'sendCode']);
            Route::post('verify',  [ForgotPasswordController::class, 'verifyCode']);
            Route::post('reset', [ForgotPasswordController::class, 'resetPassword']);
        });
        Route::controller(AddMoneyController::class)->prefix("add-money")->group(function () {
            Route::get('success/response/{gateway}', 'success')->name('api.payment.success');
            Route::get("cancel/response/{gateway}", 'cancel')->name('api.payment.cancel');

            Route::get('stripe/payment/success/{trx}', 'stripePaymentSuccess')->name('stripe.payment.success');
        });

        Route::middleware('auth.api')->group(function () {
            Route::get('logout', [AuthorizationController::class, 'logout']);
            Route::post('otp/verify', [AuthorizationController::class, 'verifyCode']);
            Route::post('resend/code', [AuthorizationController::class, 'resendCode']);

            Route::middleware('checkStatusApiUser')->group(function () {
                //Dashboard
                Route::controller(DashboardController::class)->name('dashboard.')->group(function () {
                    Route::get('dashboard', 'dashboard')->name('index');
                });

                // User Profile
                Route::controller(ProfileController::class)->prefix('profile')->middleware('app.mode')->group(function () {
                    Route::get('/', 'profile');
                    Route::post('update', 'profileUpdate');
                    Route::post('password/update', 'passwordUpdate');
                    Route::get('delete', 'accountDelete');
                });

                Route::controller(AddBabyPetController::class)->prefix('add-baby-pet')->group(function () {
                    Route::get('/', 'myBabyPet');
                    Route::post('store', 'store');
                    Route::post('update', 'update');
                    Route::post('delete', 'delete');
                });

                Route::controller(NannyListController::class)->prefix('nanny-list')->group(function () {
                    Route::get('/', 'index');
                    Route::get('nanny/details/{id}', 'nannyDetails');
                    Route::get('service/request/{id}', 'serviceRequest');
                });

                Route::controller(UserRequestController::class)->prefix('user-request')->group(function () {
                    Route::post('submit/{id}', 'userRequestSubmit');
                    Route::post('rating', 'rating')->name('rating');
                });
                Route::controller(ServiceTrakingController::class)->prefix('service-tracking')->group(function () {
                    Route::get('/', 'index');
                    Route::post('cancel', 'cancel');
                });

                Route::controller(AddMoneyController::class)->prefix('add-money')->name('add-money.')->group(function () {
                    Route::get('information', 'AddMoneyInformation');
                    Route::post('submit-data', 'submitData');

                    // Automatic
                    Route::post('stripe/payment/confirm', 'paymentConfirmedApi')->name('stripe.payment.confirmed');
                    // Manual
                    Route::post('manual/payment/confirmed', 'manualPaymentConfirmedApi')->name('manual.payment.confirmed');
                });

                Route::controller(UserNotificationController::class)->prefix('user-notification')->group(function () {
                    Route::get('/', 'index');
                });

                Route::controller(SecurityController::class)->prefix('security')->middleware('app.mode')->group(function () {
                    Route::get('/google-2fa', 'google2FA');
                    Route::post('/google-2fa/status/update', 'google2FAStatusUpdate');
                    Route::post('/google-2fa/verified', 'google2FAVerified');
                });
            });
        });
    });
});
