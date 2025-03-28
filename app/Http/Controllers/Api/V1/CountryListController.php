<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class CountryListController extends Controller
{
    function countryList()
    {
        $data = [

            'countries' => get_all_countries()
        ];
        $message =  ['success' => [__('Basic information fetch successfully')]];
        return ApiResponse::success($data, $message);
    }
}
