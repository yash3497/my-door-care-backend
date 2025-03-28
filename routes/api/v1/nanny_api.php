<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AddMoneyController;
use App\Http\Controllers\Api\V1\MoneyOutController;
use App\Http\Controllers\Api\V1\CountryListController;
use App\Http\Controllers\Api\V1\ServiceAreaController;
use App\Http\Controllers\Api\V1\Nanny\ProfileController;
use App\Http\Controllers\Api\V1\Nanny\SecurityController;
use App\Http\Controllers\Api\V1\Nanny\Auth\AuthController;
use App\Http\Controllers\Api\V1\Nanny\DashboardController;
use App\Http\Controllers\Api\V1\Nanny\ServiceRequestController;
use App\Http\Controllers\Api\V1\Nanny\NannyNotificationController;
use App\Http\Controllers\Api\V1\Nanny\Auth\AuthorizationController;
use App\Http\Controllers\Api\V1\Nanny\Auth\ForgotPasswordController;

Route::name('nanny.api.v1.')->group(function () {

    Route::get('country-list', [CountryListController::class, 'countryList']);
    Route::get('service-area', [ServiceAreaController::class, 'servicearea']);
    Route::group(['prefix' => 'nanny', 'as' => 'nanny.'], function () {

        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        Route::group(['prefix' => 'forgot/password'], function () {
            Route::post('send/otp', [ForgotPasswordController::class, 'sendCode']);
            Route::post('verify',  [ForgotPasswordController::class, 'verifyCode']);
            Route::post('reset', [ForgotPasswordController::class, 'resetPassword']);
        });

        Route::middleware('api.nanny')->group(function () {
            Route::get('logout', [AuthorizationController::class, 'logout']);
            Route::post('otp/verify', [AuthorizationController::class, 'verifyCode']);
            Route::post('resend/code', [AuthorizationController::class, 'resendCode']);
            //Nanny kyc
            Route::get('kyc', [AuthorizationController::class, 'showKycFrom']);
            Route::post('kyc/submit', [AuthorizationController::class, 'kycSubmit']);
            //Nanny Profession
            Route::post('profession/submit', [AuthorizationController::class, 'professionSubmit']);
            Route::get('service-area', [AuthorizationController::class, 'servicearea']);

            Route::middleware('checkStatusApiUser')->group(function () {

                //Dashboard
                Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
                    Route::get('/', 'dashboard');
                    Route::get('single-service/{id}', 'singleService');
                });

                // Nanny Profile
                Route::controller(ProfileController::class)->prefix('profile')->middleware('app.mode')->group(function () {
                    Route::get('/', 'profile');
                    Route::post('update', 'profileUpdate');
                    Route::post('password/update', 'passwordUpdate');
                    Route::get('profession', 'profession');
                    Route::post('profession/update', 'professionUpdate');
                    Route::get('delete', 'accountDelete');
                });

                Route::controller(ServiceRequestController::class)->prefix('service-request')->group(function () {
                    Route::get('/', 'index');
                    Route::post('update/{id}', 'serviceRequestUpdate');
                });

                Route::controller(AddMoneyController::class)->prefix('add-money')->name('add-money.')->group(function () {
                    Route::get('information', 'AddMoneyInformation');
                    Route::post('submit-data', 'submitData');

                    // Automatic
                    Route::post('stripe/payment/confirm', 'paymentConfirmedApi')->name('stripe.payment.confirmed');
                    // Manual
                    Route::post('manual/payment/confirmed', 'manualPaymentConfirmedApi')->name('manual.payment.confirmed');
                });

                Route::controller(NannyNotificationController::class)->prefix('nanny-notification')->group(function () {
                    Route::get('/', 'index');
                });

                Route::controller(SecurityController::class)->prefix('security')->middleware('app.mode')->group(function () {
                    Route::get('/google-2fa', 'google2FA');
                    Route::post('/google-2fa/status/update', 'google2FAStatusUpdate');
                    Route::post('/google-2fa/verified', 'google2FAVerified');
                });

                //Money Out
                Route::controller(MoneyOutController::class)->name('money.out.')->prefix('money-out')->group(function () {
                    Route::get('info', 'moneyOutInfo');
                    Route::post('insert', 'moneyOutInsert');
                    Route::post('confirmed', 'moneyOutConfirmed')->name('confirmed');
                });
            });
        });
    });
});
