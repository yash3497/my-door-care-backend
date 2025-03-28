<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\NannyWallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TemporaryData;
use App\Models\Admin\Currency;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use App\Constants\PaymentGatewayConst;
use App\Traits\ControlDynamicInputFields;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Traits\Transaction as TransactionTrait;

class WithdrawController extends Controller
{
    use ControlDynamicInputFields, TransactionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Money Out";
        $nanny_id = Auth::id();
        $payment_gateways = PaymentGateway::manual()->active()->get();
        $user_wallets = NannyWallet::auth()->get();
        $transactions = Transaction::with('currency')->where('nanny_id', $nanny_id)->withdraw()->orderByDesc("id", 'desc')->paginate(3);

        return view('user.sections.withdraw.index', compact('page_title', 'payment_gateways', 'user_wallets', 'transactions'));
    }

    public function submit(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'gateway'           => "required|exists:payment_gateways,alias",
            'amount'            => "required|numeric|gt:0",
            'sender_currency'   => "required|string|exists:currencies,code",
        ])->validate();

        $sender_wallet = NannyWallet::auth()->whereHas('currency', function ($query) use ($validated) {
            $query->where('code', $validated['sender_currency'])->active();
        })->first();

        $gateway = PaymentGateway::gateway($validated['gateway'])->first();
        if (!$gateway->isManual()) return back()->with(['error' => ['Gateway isn\'t available for this transaction']]);

        $gateway_currency = $gateway->currencies->first();

        $charges = $this->moneyOutCharges($validated['amount'], $gateway_currency, $sender_wallet); // Withdraw charge


        $base_currenct = Currency::default()->first();
        $base_currency_rate = $base_currenct->rate;
        $gateway_currency_rate = $gateway_currency->rate;
        $exchange_rate = $base_currency_rate / $gateway_currency_rate;

        $max_limit = $gateway_currency->max_limit * $exchange_rate;
        $min_limit = $gateway_currency->min_limit * $exchange_rate;
        $amount =  (int)$request->amount;


        if ($amount < $min_limit || $amount > $max_limit) {
            return back()->with(['error' => ['Please follow the transaction limit']]);
        }

        if ($sender_wallet->balance < $charges->total_payable) return back()->with(['error' => ['Your wallet balance is insufficient']]);
        // Store Temp Data
        try {
            $token = generate_unique_string("temporary_datas", "identifier", 16);
            TemporaryData::create([
                'type'          => PaymentGatewayConst::money_out_slug(),
                'identifier'    => $token,
                'data'          => [
                    'gateway_currency_id'   => $gateway_currency->id,
                    'wallet_id'             => $sender_wallet->id,
                    'charges'               => $charges,
                ],
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }

        return redirect()->route('nanny.withdraw.instruction', $token);
    }

    public function instruction($token)
    {
        $tempData = TemporaryData::where('identifier', $token)->first();
        $gateway_currency_id = $tempData->data->gateway_currency_id ?? "";
        if (!$gateway_currency_id) return redirect()->route('nanny.withdraw.index')->with(['error' => ['Invalid Request!']]);

        $gateway_currency = PaymentGatewayCurrency::find($gateway_currency_id);
        if (!$gateway_currency) return redirect()->route('nanny.withdraw.index')->with(['error' => ['Payment gateway currency is invalid!']]);
        $gateway = $gateway_currency->gateway;
        $input_fields = $gateway->input_fields;
        if ($input_fields == null || !is_array($input_fields)) return redirect()->route('nanny.withdraw.index')->with(['error' => ['This gateway is temporary pause or under maintenance!']]);
        $amount = $tempData->data->charges;
        $page_title = "Moneyout Instructions";
        return view('user.sections.withdraw.instructions', compact('page_title', 'gateway', 'token', 'amount'));
    }

    public function moneyOutCharges($amount, $currency, $wallet)
    {
        $data['exchange_rate']          = ($currency->rate / $wallet->currency->rate);
        $data['request_amount']         = $amount;
        $data['fixed_charge']           = $currency->fixed_charge;
        $data['gateway_percent_charge']  = $currency->percent_charge;
        $data['conversion_amount']         = $amount * $currency->rate;
        $data['percent_charge']         = ($data['conversion_amount'] * $data['gateway_percent_charge']) / 100;

        $data['gateway_currency_code']  = $currency->currency_code;
        $data['gateway_currency_id']    = $currency->id;
        $data['sender_currency_code']   = $wallet->currency->code;
        $data['sender_wallet_id']       = $wallet->id;
        $data['receive_currency']       = $currency->currency_code;
        $data['sender_currency']        = $wallet->currency->code;
        $data['total_charge']           = $data['fixed_charge']  + $data['percent_charge'];
        $data['will_get']               = ($amount * $data['exchange_rate']) - $data['total_charge'];
        $data['total_payable']          = $data['request_amount'];

        return (object) $data;
    }

    public function instructionSubmit(Request $request, $token)
    {
        $tempData = TemporaryData::where('identifier', $token)->first();
        $gateway_currency_id = $tempData->data->gateway_currency_id ?? "";
        if (!$gateway_currency_id) return redirect()->route('nanny.withdraw.index')->with(['error' => ['Invalid Request!']]);

        $gateway_currency = PaymentGatewayCurrency::find($gateway_currency_id);
        if (!$gateway_currency) return redirect()->route('nanny.withdraw.index')->with(['error' => ['Payment gateway currency is invalid!']]);
        $gateway = $gateway_currency->gateway;

        $wallet_id = $tempData->data->wallet_id ?? null;
        $wallet = NannyWallet::auth()->active()->find($wallet_id);
        if (!$wallet) return redirect()->route('nanny.withdraw.index')->with(['error' => ['Your wallet is invalid!']]);

        $this->file_store_location = "transaction";
        $dy_validation_rules = $this->generateValidationRules($gateway->input_fields);


        $validated = Validator::make($request->all(), $dy_validation_rules)->validate();
        $get_values = $this->placeValueWithFields($gateway->input_fields, $validated);

        $amount = $tempData->data->charges;
        if ($wallet->balance < $amount->total_payable) return redirect()->route('nanny.withdraw.index')->with(['error' => ['Your wallet balance is insufficient!']]);

        // Make Transaction
        DB::beginTransaction();
        try {
            $id = DB::table("transactions")->insertGetId([
                'nanny_id'                       => $wallet->nanny->id,
                'nanny_wallet_id'                => $wallet->id,
                'payment_gateway_currency_id'   => $gateway_currency->id,
                'type'                          => PaymentGatewayConst::TYPEWITHDRAW,
                'trx_id'                        => generate_unique_string('transactions', 'trx_id', 16),
                'request_amount'                => $amount->request_amount,
                'payable'                       => $amount->total_payable,
                'available_balance'             => ($wallet->balance - $amount->request_amount),
                'details'                       => json_encode(['input_values' => $get_values, 'charges' => $amount]),
                'status'                        => PaymentGatewayConst::STATUSPENDING,
                'attribute'                     => PaymentGatewayConst::SEND,
                'created_at'                    => now(),
            ]);

            $this->createTransactionChildRecords($id, $amount);

            $transaction_status = Transaction::findOrFail($id);

            DB::table($wallet->getTable())->where("id", $wallet->id)->update([
                'balance'       => ($wallet->balance - $amount->request_amount),
            ]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('nanny.withdraw.instruction', $token)->with(['error' => ['Something went wrong! Please try again']]);
        }
        $tempData->delete();

        return redirect()->route('nanny.withdraw.index')->with(['success' => ['Transaction success! Please wait for confirmation']]);
    }
}
