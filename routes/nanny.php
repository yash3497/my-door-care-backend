<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\WithdrawController;
use App\Http\Controllers\Nanny\SecurityController;
use App\Http\Controllers\Nanny\DashboardController;
use App\Http\Controllers\Nanny\NannyProfileController;
use App\Http\Controllers\Nanny\SupportTicketController;
use App\Http\Controllers\Nanny\ServiceRequestController;


Route::prefix("nanny")->name("nanny.")->group(function () {

    //Nanny Dashboard
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('dashboard');
        Route::post('logout', 'logout')->name('logout');
    });

    //Nanny Service Request
    Route::controller(ServiceRequestController::class)->prefix('service-request')->name('service.request.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('approved/{id}', 'approved')->name('approved');
        Route::get('rejected/{id}', 'rejected')->name('rejected');
        Route::get('task/complete/{id}', 'taskComplate')->name('task.complate');
        Route::get('watch/status/{id}', 'watchStatus')->name('watch.status');
    });

    //Nanny Profile
    Route::controller(NannyProfileController::class)->prefix("profile")->name("profile.")->middleware('app.mode')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/password/change', 'passwordChangeForm')->name('password.change.form');
        Route::put('password/update', 'passwordUpdate')->name('password.update');
        Route::put('update', 'update')->name('update');
        Route::post('account/delete/{id}', 'accountDelete')->name('account.delete');
        Route::put('profession/update', 'professionUpdate')->name('profession.update');
        Route::get('kyc', 'kyc')->name('kyc');
    });

    //Nanny Support
    Route::controller(SupportTicketController::class)->prefix("prefix")->name("support.ticket.")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('conversation/{encrypt_id}', 'conversation')->name('conversation');
        Route::post('message/send', 'messageSend')->name('messaage.send');
    });

    //Nanny google-2fa
    Route::controller(SecurityController::class)->prefix('security')->name('security.')->group(function () {
        Route::get('google/2fa', 'google2FA')->name('google.2fa');
        Route::post('google/2fa/status/update', 'google2FAStatusUpdate')->name('google.2fa.status.update')->middleware('app.mode');
    });

    //withdraw
    Route::controller(WithdrawController::class)->prefix("withdraw")->name('withdraw.')->middleware('nanny.kyc')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('submit', 'submit')->name('submit');
        Route::get('instruction/{token}', 'instruction')->name('instruction');
        Route::post('instruction/submit/{token}', 'instructionSubmit')->name('instruction.submit');
    });
});
