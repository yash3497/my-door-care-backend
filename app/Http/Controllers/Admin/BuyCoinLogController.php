<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\BuyCoin;
use App\Models\UserWallet;
use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Constants\NotificationConst;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BuyCoinLogController extends Controller
{
    /**
     * Display All All Logs
     * @return view
     */
    public function index()
    {
        $page_title = 'All Logs';
        $buy_coin_logs = BuyCoin::orderBy('id', 'desc')->get();

        return view('admin.sections.buy-coin.index', compact('page_title', 'buy_coin_logs'));
    }
    /**
     * Display All Pending Logs
     * @return view
     */
    public function pending()
    {
        $page_title = "Pending Logs";

        $buy_coin_logs = BuyCoin::where('status', 1)->orderBy('id', 'desc')->get();
        return view('admin.sections.buy-coin.index', compact('page_title', 'buy_coin_logs'));
    }
    /**
     * Display All Complete Logs
     * @return view
     */
    public function complete()
    {
        $page_title = "Complete Logs";
        $buy_coin_logs = BuyCoin::where('status', 2)->orderBy('id', 'desc')->get();
        return view('admin.sections.buy-coin.index', compact('page_title', 'buy_coin_logs'));
    }
    /**
     * Display All Canceled Logs
     * @return view
     */
    public function canceled()
    {
        $page_title = "Canceled Logs";
        $buy_coin_logs = BuyCoin::where('status', 3)->orderBy('id', 'desc')->get();
        return view('admin.sections.buy-coin.index', compact('page_title', 'buy_coin_logs'));
    }

    /**
     * This method for show details of add money
     * @return view $details-add-money-logs
     */
    public function buyCoinDetails($id)
    {
        $page_title = "Buy Coin Details";
        $data = BuyCoin::with('user')->where('id', $id)->orderBy('id', 'desc')->first();

        return view('admin.sections.buy-coin.details', compact('page_title', 'data'));
    }
    /**
     * This method for approved add money
     * @method PUT
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Request Response
     */
    public function approved(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = BuyCoin::where('id', $request->id)->where('status', 1)->first();


        try {
            //update wallet
            $userWallet = UserWallet::where('user_id', $data->user_id)->first();
            $userWallet->balance -=  $data->total_amount;
            $userWallet->save();
            //update transaction
            $data->status = 2;

            $data->save();

            //notification
            $notification_content = [
                'title'         => "Buy Coin",
                'message'       => "Your " . get_amount($data->coin) .  ' coin buy has been successful',
                'time'          => $userWallet->updated_at->diffForHumans(),
                'image'         => files_asset_path('profile-default'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::BUY_COIN,
                'user_id'  =>  $data->user_id,
                'message'   => $notification_content,
            ]);
            return redirect()->back()->with(['success' => ['Buy coin request approved successful']]);
        } catch (Exception $e) {
            return back()->with(['error' => [$e->getMessage()]]);
        }
    }

    /**
     * This method for reject add money
     * @method PUT
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Request Response
     */
    public function rejected(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'reject_reason' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = BuyCoin::where('id', $request->id)->where('status', 1)->first();
        $reject['status'] = 3;
        $reject['reject_reason'] = $request->reject_reason;

        try {
            $data->fill($reject)->save();

            $userWallet = UserWallet::where('user_id', $data->user_id)->first();
            //notification
            $notification_content = [
                'title'         => "Buy Coin",
                'message'       => "Your " . get_amount($data->coin) .  ' coin buy has been canceled',
                'time'          => $userWallet->updated_at->diffForHumans(),
                'image'         => files_asset_path('profile-default'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::BUY_COIN,
                'user_id'  =>  $data->user_id,
                'message'   => $notification_content,
            ]);
            return redirect()->back()->with(['success' => ['Buy coin request rejected successfully']]);
        } catch (Exception $e) {
            return back()->with(['error' => [$e->getMessage()]]);
        }
    }
}
