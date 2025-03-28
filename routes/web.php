<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\User\AddMoneyController;
use App\Http\Controllers\Api\V1\AddMoneyController as UserAddMoneyController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cc', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return "Cleared!";
});


Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('about', 'about')->name('about');
    Route::get('services', 'services')->name('services');
    Route::get('blog', 'blog')->name('blog');
    Route::get('blog/details/{id}/{slug}', 'blogDetails')->name('blog.details');

    Route::get('blog/by/tag/{tag}', 'blogByTag')->name('blog.by.tag');
    Route::get('contact', 'contact')->name('contact');
    Route::get('change/{lang?}', 'changeLanguage')->name('lang');
});

Route::get('link/{slug}', [SiteController::class, 'usefullLink'])->name('usefullLink');
Route::post('/subscribe', [SubscribeController::class, 'subscribe'])->name('subscribe');
Route::post('/message', [MessageController::class, 'message'])->name('message');

//for sslcommerz callback urls(web)
Route::controller(AddMoneyController::class)->prefix("add-money")->name("add.money.")->group(function () {
    //sslcommerz
    Route::post('sslcommerz/success', 'sllCommerzSuccess')->name('ssl.success');
    Route::post('sslcommerz/fail', 'sllCommerzFails')->name('ssl.fail');
    Route::post('sslcommerz/cancel', 'sllCommerzCancel')->name('ssl.cancel');
});
//for sslcommerz callback urls(api)
Route::controller(UserAddMoneyController::class)->prefix("api-add-money")->name("api.add.money.")->group(function () {
    //sslcommerz
    Route::post('sslcommerz/success', 'sllCommerzSuccess')->name('ssl.success');
    Route::post('sslcommerz/fail', 'sllCommerzFails')->name('ssl.fail');
    Route::post('sslcommerz/cancel', 'sllCommerzCancel')->name('ssl.cancel');
    //razorpay
    Route::get('razor-payment/api-link/{trx_id}', 'razorPaymentLink')->name('razorPaymentLink');
});
