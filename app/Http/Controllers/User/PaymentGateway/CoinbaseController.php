<?php

namespace App\Http\Controllers\User\PaymentGateway;

use Illuminate\Http\Request;
use CoinbaseCommerce\ApiClient;
use App\Http\Controllers\Controller;

class CoinbaseController extends Controller
{
    public function coinbasePayment(Request $request)
    {
        //Make sure you don't store your API Key in your source code!
        $apiClientObj = ApiClient::init();
    

    }
}
