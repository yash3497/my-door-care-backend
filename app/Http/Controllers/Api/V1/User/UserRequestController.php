<?php

namespace App\Http\Controllers\Api\V1\User;

use DateTime;
use Exception;
use App\Models\Nanny;
use App\Models\Review;
use App\Models\AddBabyPat;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\TransactionSetting;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class UserRequestController extends Controller
{
    function userRequestSubmit(Request $request, $id)
    {

        $validated = Validator::make($request->all(), [
            'add_baby_pet_id' => 'required|integer',
            'started_date' => 'required|date',
            'end_date' => 'required|date',
            'daily_working_hour' => 'required|integer',
            'started_time' => 'required',
            'address' => 'required|string',
        ])->validate();

        $nanny = Nanny::findOrFail($id);

        $nanny_profession_type = $nanny->nannyProfession->profession_type;
        $myBabyPets = AddBabyPat::where('id', $request->add_baby_pet_id)->first();


        $service_charge =  TransactionSetting::without('admin')->first();

        //service day
        $today = new DateTime();
        $today->setTime(0, 0, 0);
        $started_date = new DateTime($request->started_date);
        $end_date = new DateTime($request->end_date);
        if ($started_date < $today || $end_date < $started_date) {
            $error = ['error' => [__('Start date and end date should be today or later')]];
            return ApiResponse::error($error);
        }

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

        $trx = "RN" . getTrxNum();
        //currency code
        $currency_code = get_default_currency_code();
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
        } catch (Exception $e) {
            $error = ['error' => [__('Something was wrong. Please try again')]];
            return ApiResponse::error($error);
        }

        $message = ['success' => [__('Request submitted successfully')]];
        return ApiResponse::onlysuccess($message);
    }
    function rating(Request $request)
    {

        $validated = Validator::make($request->all(), [
            'rating' => 'required|integer',
            'comment' => 'nullable|string',
            'user_request_id' => 'required|numeric',
        ])->validate();

        $user_request_id = $validated['user_request_id'];
        $user_request = UserRequest::find($request->user_request_id);


        $nanny_id = $user_request->nanny_id;
        $user_id = $user_request->user_id;


        $validated['nanny_id'] = $nanny_id;
        $validated['user_id'] = $user_id;
        try {
            DB::beginTransaction();
            Review::create($validated);
            $user_request->update([
                'status' => 6
            ]);
            DB::commit();
        } catch (Exception $e) {

            DB::rollBack();
            $error = ['error' => [__('Something went wrong. Please try again')]];
            return ApiResponse::error($error);
        }
        $message = ['success' => [__('Thank you for your rating')]];
        return ApiResponse::onlysuccess($message);
    }
}
