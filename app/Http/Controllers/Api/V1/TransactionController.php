<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Constants\PaymentGatewayConst;
use App\Http\Resources\AddMoneyLogs;
use App\Http\Resources\BuyCoinLogs;
use App\Http\Resources\MoneyOutLogs;
use App\Http\Resources\SellCoinLogs;
use App\Http\Helpers\Api\Helpers as ApiResponse;
use App\Models\BuyCoin;

class TransactionController extends Controller
{
    public function allTransactionLog(Request $request)
    {
        $addMoney           = Transaction::auth()->where('type', PaymentGatewayConst::TYPEADDMONEY)->orderByDesc("id")->get();
        $withdrow           = Transaction::auth()->where('type', PaymentGatewayConst::TYPEWITHDRAW)->orderByDesc("id")->get();
        $buyCoin           = BuyCoin::where('user_id', auth()->user()->id)->orderByDesc("id")->get();
        $sellCoin           = Transaction::auth()->where('type', PaymentGatewayConst::TYPESELLCOIN)->orderByDesc("id")->get();

        $transactions = [
            'addMoney'          => AddMoneyLogs::collection($addMoney),
            'withdrow'     => MoneyOutLogs::collection($withdrow),
            'buyCoin'    => BuyCoinLogs::collection($buyCoin),
            'sellCoin'    => SellCoinLogs::collection($sellCoin),
        ];
        $transactions = (object)$transactions;


        $success = ['success' => [__('All transaction logs')]];
        return ApiResponse::success($success, $transactions);
    }
}
