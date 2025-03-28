<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\UserWallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Constants\NotificationConst;
use App\Constants\PaymentGatewayConst;
use App\Http\Controllers\Controller;
use App\Models\NannyNotification;
use App\Models\NannyWallet;
use Illuminate\Support\Facades\Validator;

class MoneyOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page_title = "All Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->paginate(20);
        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function reviewPayment()
    {
        $page_title = "Review Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->where('status', 1)->paginate(20);

        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function pending()
    {
        $page_title = "Pending Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->where('status', 2)->paginate(20);

        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function confirmPayment()
    {
        $page_title = "Confirm Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->where('status', 3)->paginate(20);

        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function onhold()
    {
        $page_title = "On Hold Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->where('status', 4)->paginate(20);

        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function settled()
    {
        $page_title = "Settled Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->where('status', 5)->paginate(20);

        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function completed()
    {
        $page_title = "Completed Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->where('status', 6)->paginate(20);

        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function canceled()
    {
        $page_title = "Canceled Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->where('status', 7)->paginate(20);

        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function failed()
    {
        $page_title = "Failed Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->where('status', 8)->paginate(20);

        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function refunded()
    {
        $page_title = "Refunded Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->where('status', 9)->paginate(20);

        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function delayed()
    {
        $page_title = "Dalayed Logs";
        $transactions = Transaction::with(
            'user:id,firstname,email,username,mobile',
            'payment_gateway:id,name',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->where('status', 10)->paginate(20);

        return view('admin.sections.money-out.index', compact(
            'page_title',
            'transactions'
        ));
    }

    public function details($id)
    {
        $data = Transaction::where('id', $id)->with(
            'user:id,firstname,email,username,full_mobile',
            'currency:id,name,alias,payment_gateway_id,currency_code,rate',
        )->where('type', PaymentGatewayConst::TYPEWITHDRAW)->first();
        $page_title = "Money Out details for" . '  ' . $data->trx_id;
        return view('admin.sections.money-out.details', compact(
            'page_title',
            'data',

        ));
    }

    function statusUpdate(Request $request, $id)
    {
        $validated = Validator::make($request->all(), ['status' => 'integer'])->validate();
        $transaction_id = Transaction::findOrFail($id);

        // 1: Review Payment, 2: Pending, 3: Confirm Payment, 4: On Hold, 5: Settled, 6: Completed, 7: Canceled, 8: Failed,
        // 9: Refunded, 10: Delayed 11: Reject


        if ($validated['status'] == $transaction_id['status']) {
            return back()->with(['error' => [__('Please select another status for update')]]);
        }
        try {

            $transaction_id->update($validated);
            $data = Transaction::where('type', PaymentGatewayConst::TYPEWITHDRAW)->whereIn('status', [7, 8, 9, 11])->first();
            $message = 'Money Out status updated';

            if (isset($data)) {
                $userWallet = NannyWallet::where('nanny_id', $transaction_id->nanny_wallet_id)->first();
                $userWallet->balance +=  $data->payable;
                $userWallet->save();
            }
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong!. Please try again.']]);
        }
        return back()->with(['success' => ['Status updated successfully']]);
    }

    public function rejected(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'rejected_id' => 'required|integer',
            'rejection_reason' => 'nullable|string'
        ])->validate();

        $transaction_id = Transaction::findOrFail($validated['rejected_id']);


        if (11 == $transaction_id['status']) {
            return back()->with(['error' => [__('Please select another status for update')]]);
        }

        try {

            $transaction_id->update([
                'status' => 11,
                'reject_reason' => $validated['rejection_reason']
            ]);

            $data = Transaction::where([['type', PaymentGatewayConst::TYPEWITHDRAW]])->whereIn('status', [11])->first();
            $message = 'Money Out status updated';

            if (isset($data)) {
                $userWallet = NannyWallet::where('nanny_id', $transaction_id->nanny_wallet_id)->first();
                $userWallet->balance +=  $data->payable;
                $userWallet->save();
            }

            $message = "Your Wallet (" . $userWallet->currency->code . ") balance  has been added " . get_amount($data->request_amount) . ' ' . $userWallet->currency->code;
            //notification
            $notification_content = [
                'title'         => "Money OUt",
                'message'       => $message,
                'time'          => now(),
                'image'         => files_asset_path('profile-default'),
            ];

            NannyNotification::create([
                'type'      => NotificationConst::BALANCE_ADDED,
                'nanny_id'  => $transaction_id->nanny->id,
                'message'   => $notification_content,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong!. Please try again.']]);
        }

        return back()->with(['success' => ['Rejected successfully']]);
    }
}
