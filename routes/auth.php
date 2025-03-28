<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\User\Auth\ForgotPasswordController as UserForgotPasswordController;
use App\Http\Controllers\User\Auth\LoginController as UserLoginController;
use App\Http\Controllers\User\Auth\RegisterController as UserRegisterController;
use App\Http\Controllers\User\Auth\SocialAuthentication;
use App\Http\Controllers\User\AuthorizationController;

use App\Http\Controllers\Nanny\Auth\ForgotPasswordController as NannyForgotPasswordController;
use App\Http\Controllers\Nanny\Auth\RegisterController as NannyRegisterController;
use App\Http\Controllers\Nanny\Auth\LoginController as NannyLoginController;
use App\Http\Controllers\Nanny\AuthorizationController as NannyAuthorizationController;

// Admin Authentication Route
Route::middleware(['guest', 'admin.login.guard'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    Route::get('login', [LoginController::class, "showLoginForm"])->name('login');
    Route::post('login/submit', [LoginController::class, "login"])->name('login.submit');

    Route::get('password/forgot', [ForgotPasswordController::class, "showLinkRequestForm"])->name('password.forgot');
    Route::post('password/forgot', [ForgotPasswordController::class, "sendResetLinkEmail"])->name('password.forgot.request');

    Route::get('password/reset/{token}', [ResetPasswordController::class, "showResetForm"])->name('password.reset');
    Route::post('password/update', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::name('user.')->prefix('user')->group(function () {
    Route::get('/', function () {
        return redirect()->route('user.login');
    });
    Route::get('login', [UserLoginController::class, "showLoginForm"])->name('login');
    Route::post('login/submit', [UserLoginController::class, "login"])->name('login.submit');

    Route::get('register', [UserRegisterController::class, "showRegistrationForm"])->name('register');
    Route::post('register/submit', [UserRegisterController::class, "register"])->name('register.submit');

    Route::controller(UserForgotPasswordController::class)->prefix("password")->name("password.")->group(function () {
        Route::get('forgot', 'showForgotForm')->name('forgot');
        Route::post('forgot/send/code', 'sendCode')->name('forgot.send.code');
        Route::get('forgot/code/verify/form/{token}', 'showVerifyForm')->name('forgot.code.verify.form');
        Route::post('forgot/verify/{token}', 'verifyCode')->name('forgot.verify.code');
        Route::get('forgot/resend/code/{token}', 'resendCode')->name('forgot.resend.code');
        Route::get('forgot/reset/form/{token}', 'showResetForm')->name('forgot.reset.form');
        Route::post('forgot/reset/{token}', 'resetPassword')->name('reset');
    });

    Route::controller(SocialAuthentication::class)->prefix('oauth')->name('social.auth.')->group(function () {
        Route::get('google', 'google')->name('google');
        Route::get('google/response', 'googleResponse');
        Route::get('facebook', 'facebook')->name('facebook');
        Route::get('facebook/response', 'facebookResponse');
    });

    Route::controller(AuthorizationController::class)->prefix("authorize")->name('authorize.')->middleware("auth")->group(function () {
        Route::get('mail/{token}', 'showMailFrom')->name('mail');
        Route::post('mail/verify/{token}', 'mailVerify')->name('mail.verify');
        Route::get('mail/resend/{token}', 'mailResend')->name('mail.resend');
        Route::get('kyc', 'showKycFrom')->name('kyc');
        Route::post('kyc/submit', 'kycSubmit')->name('kyc.submit');
        Route::get('google/2fa', 'showGoogle2FAForm')->name('google.2fa');
        Route::post('google/2fa/submit', 'google2FASubmit')->name('google.2fa.submit');
    });
});

Route::name('nanny.')->prefix('nanny')->group(function () {

    Route::get('login', [NannyLoginController::class, "showLoginForm"])->name('login');
    Route::post('login/submit', [NannyLoginController::class, "login"])->name('login.submit');

    Route::get('register', [NannyRegisterController::class, "showRegistrationForm"])->name('register');
    Route::post('register/submit', [NannyRegisterController::class, "register"])->name('register.submit');

    Route::controller(NannyForgotPasswordController::class)->prefix("password")->name("password.")->group(function () {
        Route::get('forgot', 'showForgotForm')->name('forgot');
        Route::post('forgot/send/code', 'sendCode')->name('forgot.send.code');
        Route::get('forgot/code/verify/form/{token}', 'showVerifyForm')->name('forgot.code.verify.form');
        Route::post('forgot/verify/{token}', 'verifyCode')->name('forgot.verify.code');
        Route::get('forgot/resend/code/{token}', 'resendCode')->name('forgot.resend.code');
        Route::get('forgot/reset/form/{token}', 'showResetForm')->name('forgot.reset.form');
        Route::post('forgot/reset/{token}', 'resetPassword')->name('reset');
    });

    Route::controller(NannyAuthorizationController::class)->prefix("authorize")->name('authorize.')->middleware("auth:nanny")->group(function () {
        Route::get('mail/{token}', 'showMailFrom')->name('mail');
        Route::post('mail/verify/{token}', 'mailVerify')->name('mail.verify');
        Route::get('mail/resend/{token}', 'resendCode')->name('mail.resend');
        Route::get('kyc', 'showKycFrom')->name('kyc');
        Route::post('kyc/submit', 'kycSubmit')->name('kyc.submit');
        Route::get('profession', 'profession')->name('profession');
        Route::post('profession/submit', 'professionSubmit')->name('profession.submit');
        Route::get('google/2fa', 'showGoogle2FAForm')->name('google.2fa');
        Route::post('google/2fa/submit', 'google2FASubmit')->name('google.2fa.submit');
    });
});
