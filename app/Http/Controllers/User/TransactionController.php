<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\BuyCoin;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Constants\PaymentGatewayConst;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{

    public function slugValue($slug)
    {
        $values =  [
            'add-money'         => PaymentGatewayConst::TYPEADDMONEY,
            'money-out'         => PaymentGatewayConst::TYPEMONEYOUT,
            'transfer-money'    => PaymentGatewayConst::TYPETRANSFERMONEY,
            'money-exchange'    => PaymentGatewayConst::TYPEMONEYEXCHANGE,
            'withdraw'         => PaymentGatewayConst::TYPEWITHDRAW,
            'sell-coin'         => PaymentGatewayConst::TYPESELLCOIN,
            'buy-coin'         => PaymentGatewayConst::TYPEBUYCOIN,
        ];

        if (!array_key_exists($slug, $values)) return abort(404);
        return $values[$slug];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {

        if ($slug != null) {
            $transactions = Transaction::auth()->where("type", $this->slugValue($slug))->orderByDesc("id")->paginate(12);
            if ($slug == 'withdraw') {
                $page_title = "Money Out Log";
            } elseif ($slug == 'sell-coin') {
                $page_title = "Sell Coin Log";
            } elseif ($slug == 'add-money') {
                $page_title = "Add Money Log";
            } else {
                $page_title = ucwords(remove_speacial_char($slug, " ")) . " Log";
            }
        } else {
            $transactions = Transaction::auth()->orderByDesc("id")->paginate(12);
            $page_title = "Transaction Log";
        }

        return view('user.sections.transaction.index', compact("page_title", "transactions"));
    }
    public function buyCoinIndex($slug = null)
    {

        $page_title = "Buy Coin Log";

        $buy_coins = BuyCoin::orderByDesc('id')->where('user_id', Auth::id())->paginate(12);



        return view('user.sections.transaction.buy-index', compact("page_title", "buy_coins"));
    }


    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return Response::error($validator->errors(), null, 400);
        }

        $validated = $validator->validate();

        try {
            $transactions = Transaction::auth()->search($validated['text'])->take(10)->get();
        } catch (Exception $e) {
            $error = ['error' => ['Something went worng!. Please try again.']];
            return Response::error($error, null, 500);
        }

        return view('user.components.search.transaction-log', compact('transactions'));
    }
}
