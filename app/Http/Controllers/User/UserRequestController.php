<?php

namespace App\Http\Controllers\User;

use DateTime;
use Exception;
use App\Models\Nanny;
use App\Models\Review;
use App\Models\AddBabyPat;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\NannyNotification;
use Illuminate\Support\Facades\DB;
use App\Constants\NotificationConst;
use App\Events\Nanny\NannyRequestEvent;
use App\Http\Controllers\Controller;
use App\Models\Admin\TransactionSetting;
use Illuminate\Support\Facades\Validator;

class UserRequestController extends Controller
{
    function userRequestSubmit(Request $request, $id)
    {
        $validated = Validator::make($request->all(), [
            'add_baby_pet_id' => 'required|integer',
            'started_date' => 'required|date',
            'end_date' => 'required|date',
            'daily_working_hour' => 'required|integer|max:24',
            'started_time' => 'required',
            'address' => 'required|string',
        ])->validate();

        $nanny = Nanny::findOrFail($id);
        $nanny_profession_type = $nanny->nannyProfession->profession_type;
        $myBabyPets = AddBabyPat::where('id', $request->add_baby_pet_id)->first();

        $service_charge =  TransactionSetting::without('admin')->first();
        //service day
        $started_date = new DateTime($request->started_date);
        $end_date = new DateTime($request->end_date);
        $service_day = $end_date->diff($started_date)->format("%a") + 1;
        //daily working hour
        $daily_working_hour = $request->daily_working_hour;
        //started time
        $started_time = $request->started_time;


        //Nanny charge
        if ($nanny->nannyProfession->charge == "Hourly") {
            $nanny_charge = $nanny->nannyProfession->amount;
        } else if ($nanny->nannyProfession->charge == "Daily") {
            $nanny_charge = 1 / $nanny->nannyProfession->amount;
            $nanny_charge = ($daily_working_hour * $service_day * $nanny_charge);
        } else if ($nanny->nannyProfession->charge == "Weekly") {
            $nanny_charge = 7 / $nanny->nannyProfession->amount;
            $nanny_charge = ($daily_working_hour * $service_day * $nanny_charge);
        } else if ($nanny->nannyProfession->charge == "Monthly") {
            $nanny_charge = 30 / $nanny->nannyProfession->amount;
            $nanny_charge = ($daily_working_hour * $service_day * $nanny_charge);
        }
        //total hour
        $total_hours = $daily_working_hour * $service_day;
        //total
        $total = $total_hours * $nanny_charge;

        //service charge
        $fixed_charge = $service_charge->fixed_charge;
        $percent_charge = ($service_charge->percent_charge / 100) * $total;
        $total_service_charge = $fixed_charge + $percent_charge;

        //payable
        $payable = $total + $total_service_charge;

        //currency code
        $currency_code = get_default_currency_code();

        $trx = "RN" . getTrxNum();

        $validated['user_id'] = $myBabyPets->user_id;
        $validated['nanny_id'] = $id;
        $validated['add_baby_pet_id'] = $myBabyPets->id;
        $validated['service_type'] = $myBabyPets->profession_type;
        $validated['service_day'] = $service_day;
        $validated['daily_working_hour'] = $daily_working_hour;
        $validated['total_hour'] = $total_hours;
        $validated['nanny_charge'] = $nanny_charge;
        $validated['total'] = $total;
        $validated['service_charge'] = $total_service_charge;
        $validated['payable'] = $payable;
        $validated['currency_code'] = $currency_code;
        $validated['trx'] = $trx;

        try {

            UserRequest::create($validated);
            event(new NannyRequestEvent($validated));
        } catch (Exception $e) {
            return back()->with(['error' => ['Something was wrong. Please try again']]);
        }

        return redirect()->route('user.nanny.list.index')->with(['success' => ['Request submitted successfully']]);
    }
    function rating(Request $request)
    {
        $user_request = UserRequest::find($request->review_id);

        $nanny_id = $user_request->nanny_id;
        $user_id = $user_request->user_id;

        $validated = Validator::make($request->all(), [
            'rating' => 'required|integer',
            'comment' => 'nullable|string'
        ])->validate();
        $validated['nanny_id'] = $nanny_id;
        $validated['user_id'] = $user_id;
        $validated['user_request_id'] = $user_request->id;
        try {
            DB::beginTransaction();
            Review::create($validated);
            $user_request->update([
                'status' => 6
            ]);
            //notification
            $notification_content = [
                'title'         => "Review",
                'message'       => auth()->user()->fullname . " have given review",
                'time'          => Carbon::now()->diffForHumans(),
                'image'         => files_asset_path('profile-default'),
            ];
            NannyNotification::create([
                'type'      => NotificationConst::USER_REVIEW,
                'nanny_id'  => $nanny_id,
                'message'   => $notification_content,
            ]);
            DB::commit();
        } catch (Exception $e) {

            DB::rollBack();
            return back()->with(['error' => ['Something went wrong. Please try again']]);
        }
        return redirect()->route('user.nanny.list.index')->with(['success' => ['Thank you for your valuable rating']]);
    }
}
