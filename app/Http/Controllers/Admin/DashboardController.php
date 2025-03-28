<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\BuyCoin;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Models\UserSupportTicket;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Constants\PaymentGatewayConst;
use App\Models\Admin\Currency;
use App\Models\Nanny;
use App\Providers\Admin\BasicSettingsProvider;
use Pusher\PushNotifications\PushNotifications;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Dashboard";
        //Addmoney
        $total_addmoney = Transaction::where('type', 'ADD-MONEY')->orWhere('status', 1)->orWhere('status', 2)->sum('request_amount');
        $success_addmoney = Transaction::where('type', 'ADD-MONEY')->where('status', 1)->sum('request_amount');
        $panding_addmoney = Transaction::where('type', 'ADD-MONEY')->where('status', 2)->sum('request_amount');
        if ($panding_addmoney == 0) {
            $percent_addmoney = 0;
        } else {
            $percent_addmoney = ($success_addmoney / ($success_addmoney + $panding_addmoney)) * 100;
        }

        //Withdraw
        $total_withdraw = Transaction::where('type', 'WITHDRAW')->orWhere('status', 1)->orWhere('status', 2)->sum('request_amount');
        $success_withdraw = Transaction::where('type', 'WITHDRAW')->where('status', 1)->sum('request_amount');
        $panding_withdraw = Transaction::where('type', 'WITHDRAW')->where('status', 2)->sum('request_amount');
        if ($panding_withdraw == 0) {
            $percent_withdraw = 0;
        } else {
            $percent_withdraw = ($success_withdraw / ($success_withdraw + $panding_withdraw)) * 100;
        }
        //Sell Coin
        $total_sell_coin = Transaction::where('type', 'SELL-COIN')->orWhere('status', 1)->orWhere('status', 2)->sum('request_amount');
        $success_sell_coin = Transaction::where('type', 'SELL-COIN')->where('status', 1)->sum('request_amount');
        $panding_sell_coin = Transaction::where('type', 'SELL-COIN')->where('status', 2)->sum('request_amount');
        if ($panding_sell_coin == 0) {
            $percent_sell_coin = 0;
        } else {
            $percent_sell_coin = ($success_sell_coin / ($success_sell_coin + $panding_sell_coin)) * 100;
        }
        //Buy Coin
        $total_buy_coin = BuyCoin::orWhere('status', 1)->orWhere('status', 2)->sum('coin');
        $panding_buy_coin = BuyCoin::where('status', 1)->sum('coin');
        $success_buy_coin = BuyCoin::where('status', 2)->sum('coin');
        if ($panding_buy_coin == 0) {
            $percent_buy_coin = 0;
        } else {
            $percent_buy_coin = ($success_buy_coin / ($success_buy_coin + $panding_buy_coin)) * 100;
        }

        //Users
        $total_users = User::toBase()->count();
        $active_users =  User::active()->count();
        $unverified_users = User::EmailUnverified()->count();

        if ($unverified_users == 0 && $active_users != 0) {
            $user_perchant = 100;
        } elseif ($unverified_users == 0 && $active_users == 0) {
            $user_perchant = 0;
        } else {
            $user_perchant = ($active_users / ($active_users + $unverified_users)) * 100;
        }

        //Nanny
        $total_nannies = Nanny::toBase()->count();
        $active_nannies =  Nanny::active()->count();
        $unverified_nannies = Nanny::EmailUnverified()->count();
        if ($unverified_nannies == 0 && $active_nannies != 0) {
            $nanny_perchant = 100;
        } elseif ($unverified_nannies == 0 && $active_nannies == 0) {
            $nanny_perchant = 0;
        } else {
            $nanny_perchant = ($active_nannies / ($active_nannies + $unverified_nannies)) * 100;
        }
        //Transaction
        $total_transaction = Transaction::sum('request_amount');
        $panding_transaction = Transaction::where('status', 1)->sum('request_amount');
        $success_transaction = Transaction::where('status', 2)->sum('request_amount');
        if ($panding_transaction == 0) {
            $percent_transaction = 0;
        } else {
            $percent_transaction = ($success_transaction / ($success_transaction + $panding_transaction)) * 100;
        }

        //Support Tikets
        $total_tickets = UserSupportTicket::toBase()->count();

        $active_tickets =  UserSupportTicket::active()->count();
        $pending_tickets = UserSupportTicket::Pending()->count();

        if ($pending_tickets == 0 && $active_tickets != 0) {
            $ticket_perchant = 100;
        } elseif ($pending_tickets == 0 && $active_tickets == 0) {
            $ticket_perchant = 0;
        } else {
            $ticket_perchant = ($active_tickets / ($active_tickets + $pending_tickets)) * 100;
        }

        // Chart four | User analysis
        $total_user = User::toBase()->count();
        $unverified_user = User::toBase()->where('email_verified', 0)->count();
        $active_user = User::toBase()->where('status', 1)->count();
        $banned_user = User::toBase()->where('status', 0)->count();
        $chart_four = [$active_user, $banned_user, $unverified_user, $total_user];
        // Chart five | Nanny analysis
        $total_nanny = Nanny::toBase()->count();
        $unverified_nanny = Nanny::toBase()->where('email_verified', 0)->count();
        $active_nanny = Nanny::toBase()->where('status', 1)->count();
        $banned_nanny = Nanny::toBase()->where('status', 0)->count();
        $chart_five = [$active_nanny, $banned_nanny, $unverified_nanny, $total_nanny];

        //charts
        // Monthly Add Money
        $start = strtotime(date('Y-m-01'));
        $end = strtotime(date('Y-m-31'));

        // Add Money
        $pending_data  = [];
        $success_data  = [];
        $canceled_data = [];
        $hold_data     = [];

        // Money Out
        $Money_out_pending_data  = [];
        $Money_out_success_data  = [];
        $Money_out_canceled_data = [];
        $Money_out_hold_data     = [];
        // Sell Coin
        $sell_coin_pending_data  = [];
        $sell_coin_success_data  = [];
        $sell_coin_canceled_data = [];
        $sell_coin_hold_data     = [];
        // Sell Coin
        $buy_coin_pending_data  = [];
        $buy_coin_success_data  = [];
        $sell_coin_canceled_data = [];
        $buy_coin_hold_data     = [];

        $month_day  = [];
        while ($start <= $end) {
            $start_date = date('Y-m-d', $start);

            // Monthley add money
            $pending = Transaction::where('type', PaymentGatewayConst::TYPEADDMONEY)
                ->whereDate('created_at', $start_date)
                ->where('status', 2)
                ->count();
            $success = Transaction::where('type', PaymentGatewayConst::TYPEADDMONEY)
                ->whereDate('created_at', $start_date)
                ->where('status', 1)
                ->count();
            $canceled = Transaction::where('type', PaymentGatewayConst::TYPEADDMONEY)
                ->whereDate('created_at', $start_date)
                ->where('status', 4)
                ->count();
            $hold = Transaction::where('type', PaymentGatewayConst::TYPEADDMONEY)
                ->whereDate('created_at', $start_date)
                ->where('status', 3)
                ->count();
            $pending_data[]  = $pending;
            $success_data[]  = $success;
            $canceled_data[] = $canceled;
            $hold_data[]     = $hold;

            // Monthley money Out
            $money_pending = Transaction::where('type', PaymentGatewayConst::TYPEMONEYOUT)
                ->whereDate('created_at', $start_date)
                ->where('status', 2)
                ->count();
            $money_success = Transaction::where('type', PaymentGatewayConst::TYPEMONEYOUT)
                ->whereDate('created_at', $start_date)
                ->where('status', 1)
                ->count();
            $money_canceled = Transaction::where('type', PaymentGatewayConst::TYPEMONEYOUT)
                ->whereDate('created_at', $start_date)
                ->where('status', 4)
                ->count();
            $money_hold = Transaction::where('type', PaymentGatewayConst::TYPEMONEYOUT)
                ->whereDate('created_at', $start_date)
                ->where('status', 3)
                ->count();
            $Money_out_pending_data[]  = $money_pending;
            $Money_out_success_data[]  = $money_success;
            $Money_out_canceled_data[] = $money_canceled;
            $Money_out_hold_data[]     = $money_hold;
            // Monthley sell coin
            $sell_coin_pending = Transaction::where('type', PaymentGatewayConst::TYPESELLCOIN)
                ->whereDate('created_at', $start_date)
                ->where('status', 2)
                ->count();
            $sell_coin_success = Transaction::where('type', PaymentGatewayConst::TYPESELLCOIN)
                ->whereDate('created_at', $start_date)
                ->where('status', 1)
                ->count();
            $sell_coin_canceled = Transaction::where('type', PaymentGatewayConst::TYPESELLCOIN)
                ->whereDate('created_at', $start_date)
                ->where('status', 4)
                ->count();
            $sell_coin_hold = Transaction::where('type', PaymentGatewayConst::TYPESELLCOIN)
                ->whereDate('created_at', $start_date)
                ->where('status', 3)
                ->count();
            $sell_coin_pending_data[]  = $sell_coin_pending;
            $sell_coin_success_data[]  = $sell_coin_success;
            $sell_coin_canceled_data[] = $sell_coin_canceled;
            $sell_coin_hold_data[]     = $sell_coin_hold;
            // Monthley buy coin
            $buy_coin_pending = BuyCoin::whereDate('created_at', $start_date)
                ->where('status', 1)
                ->count();
            $buy_coin_success = BuyCoin::whereDate('created_at', $start_date)
                ->where('status', 2)
                ->count();
            $buy_coin_canceled = BuyCoin::whereDate('created_at', $start_date)
                ->where('status', 3)
                ->count();
            $buy_coin_hold = BuyCoin::whereDate('created_at', $start_date)
                ->where('status', 4)
                ->count();
            $buy_coin_pending_data[]  = $buy_coin_pending;
            $buy_coin_success_data[]  = $buy_coin_success;
            $buy_coin_canceled_data[] = $buy_coin_canceled;
            $buy_coin_hold_data[]     = $buy_coin_hold;

            $month_day[] = date('Y-m-d', $start);
            $start = strtotime('+1 day', $start);
        }

        // Chart one
        $chart_one_data = [
            'pending_data'  => $pending_data,
            'success_data'  => $success_data,
            'canceled_data' => $canceled_data,
            'hold_data'     => $hold_data,
        ];

        // Chart three
        $chart_three_data = [
            'pending_data'  => $Money_out_pending_data,
            'success_data'  => $Money_out_success_data,
            'canceled_data' => $Money_out_canceled_data,
            'hold_data'     => $Money_out_hold_data,
        ];
        // Chart four
        $chart_four_data = [
            'pending_data'  => $sell_coin_pending_data,
            'success_data'  => $sell_coin_success_data,
            'canceled_data' => $sell_coin_canceled_data,
            'hold_data'     => $sell_coin_hold_data,
        ];
        $chart_five_data = [
            'pending_data'  => $buy_coin_pending_data,
            'success_data'  => $buy_coin_success_data,
            'canceled_data' => $buy_coin_canceled_data,
            'hold_data'     => $buy_coin_hold_data,
        ];



        $data = [
            'chart_one_data' => $chart_one_data,
            'chart_three_data' => $chart_three_data,
            'chart_four_data' => $chart_four_data,
            'chart_five_data' => $chart_five_data,
            'month_day'        => $month_day,
        ];
        $latest_add_moneys = Transaction::where('type', PaymentGatewayConst::TYPEADDMONEY)->where('status', 1)->limit(5)->latest()->get();
        $default_currency = Currency::default();
        return view('admin.sections.dashboard.index', compact(
            'page_title',
            'total_addmoney',
            'success_addmoney',
            'panding_addmoney',
            'percent_addmoney',
            'total_withdraw',
            'success_withdraw',
            'panding_withdraw',
            'percent_withdraw',
            'total_sell_coin',
            'success_sell_coin',
            'panding_sell_coin',
            'percent_sell_coin',
            'total_buy_coin',
            'success_buy_coin',
            'panding_buy_coin',
            'percent_buy_coin',
            'total_users',
            'active_users',
            'unverified_users',
            'user_perchant',
            'total_nannies',
            'active_nannies',
            'unverified_nannies',
            'nanny_perchant',
            'total_tickets',
            'active_tickets',
            'pending_tickets',
            'ticket_perchant',
            'chart_four',
            'chart_five',
            'data',
            'total_transaction',
            'panding_transaction',
            'success_transaction',
            'percent_transaction',
            'default_currency'
        ));
    }


    /**
     * Logout Admin From Dashboard
     * @return view
     */
    public function logout(Request $request)
    {
        $push_notification_setting = BasicSettingsProvider::get()->push_notification_config;

        if ($push_notification_setting) {
            $method = $push_notification_setting->method ?? false;

            if ($method == "pusher") {
                $instant_id     = $push_notification_setting->instance_id ?? false;
                $primary_key    = $push_notification_setting->primary_key ?? false;

                if ($instant_id && $primary_key) {
                    $pusher_instance = new PushNotifications([
                        "instanceId"    => $instant_id,
                        "secretKey"     => $primary_key,
                    ]);

                    $pusher_instance->deleteUser("" . Auth::user()->id . "");
                }
            }
        }

        $admin = auth()->user();
        try {
            $admin->update([
                'last_logged_out'   => now(),
                'login_status'      => false,
            ]);
        } catch (Exception $e) {
            // Handle Error
        }

        Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    /**
     * Function for clear admin notification
     */
    public function notificationsClear()
    {
        $admin = auth()->user();

        if (!$admin) {
            return false;
        }

        try {
            $admin->update([
                'notification_clear_at'     => now(),
            ]);
        } catch (Exception $e) {
            $error = ['error' => ['Something went worng! Please try again.']];
            return Response::error($error, null, 404);
        }

        $success = ['success' => ['Notifications clear successfully!']];
        return Response::success($success, null, 200);
    }
}
