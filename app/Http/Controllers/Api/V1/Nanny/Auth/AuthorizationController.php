<?php

namespace App\Http\Controllers\Api\V1\Nanny\Auth;

use Exception;
use App\Models\Nanny;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Models\Admin\SetupKyc;
use Illuminate\Support\Carbon;
use App\Models\NannyProfession;
use App\Models\NannyAuthorization;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User\UserResource;
use App\Traits\ControlDynamicInputFields;
use Illuminate\Support\Facades\Validator;
use App\Providers\Admin\BasicSettingsProvider;
use App\Http\Helpers\Api\Helpers as ApiResponse;
use App\Models\Admin\ServiceArea;
use App\Notifications\Nanny\Auth\SendAuthorizationCode;


class AuthorizationController extends Controller
{
    use ControlDynamicInputFields;
    /**
     * Verify user mail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resendCode(Request $request)
    {
        $user = auth()->user();
        $resend = NannyAuthorization::where("nanny_id", $user->id)->first();
        if ($resend) {
            if (Carbon::now() <= $resend->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE)) {

                $error = ['error' => ['You can resend verification code after ' . Carbon::now()->diffInSeconds($resend->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE)) . ' seconds']];
                return ApiResponse::error($error);
            }
        }
        $data = [
            'nanny_id'       =>  $user->id,
            'code'          => generate_random_code(),
            'token'         => generate_unique_string("nanny_authorizations", "token", 200),
            'created_at'    => now(),
        ];
        DB::beginTransaction();
        try {
            if ($resend) {
                NannyAuthorization::where("nanny_id", $user->id)->delete();
            }
            DB::table("nanny_authorizations")->insert($data);
            $user->notify(new SendAuthorizationCode((object) $data));
            DB::commit();
            $message =  ['success' => ['Varification code send success']];
            return ApiResponse::onlysuccess($message);
        } catch (Exception $e) {
            DB::rollBack();
            $error = ['error' => ['Something went worng! Please try again']];
            return ApiResponse::error($error);
        }
    }

    /**
     * Verify user mail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
        ]);
        if ($validator->fails()) {
            $error =  ['error' => $validator->errors()->all()];
            return ApiResponse::validation($error);
        }
        $code = $request->otp;
        $user = Auth::user();
        $otp_exp_sec = BasicSettingsProvider::get()->otp_exp_seconds ?? GlobalConst::DEFAULT_TOKEN_EXP_SEC;
        $auth_column = NannyAuthorization::where("code", $code)->where('nanny_id', $user->id)->first();

        if (!$auth_column) {
            $error = ['error' => ['Verification code does not match']];
            return ApiResponse::error($error);
        }
        if ($auth_column->created_at->addSeconds($otp_exp_sec) < now()) {
            $error = ['error' => ['Session expired. Please try again']];
            return ApiResponse::error($error);
        }
        try {
            $auth_column->nanny->update([
                'email_verified'    => true,
            ]);
            $auth_column->delete();
        } catch (Exception $e) {
            $error = ['error' => ['Something went worng! Please try again']];
            return ApiResponse::error($error);
        }

        //show user when verify
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $user_data = [
            'token' => $token,
            'base_url' => url('/'),
            'image_path' => get_files_public_path('nanny-profile'),
            'default_image' => get_files_public_path('default'),
            'nanny' => new UserResource($auth_column->nanny),
        ];


        $message =  ['success' => ['Account successfully verified']];
        return ApiResponse::onlysuccess($message);
    }

    /**
     * Verify user mail
     *
     * @method GET
     * @return \Illuminate\Http\Response
     */

    public function logout()
    {
        Auth::user()->token()->revoke();
        $message = ['success' => ['Logout Successful']];
        return ApiResponse::onlysuccess($message);
    }

    public function showKycFrom()
    {
        $user = auth()->user();
        $kyc_status = $user->kyc_verified;
        $user_kyc = SetupKyc::nannyKyc()->first();
        $status_info = "1==verified, 2==pending, 0==unverified; 3=rejected";
        $kyc_data = $user_kyc->fields;
        $kyc_fields = [];
        if ($kyc_data) {
            $kyc_fields = array_reverse($kyc_data);
        }
        $data = [
            'status_info' => $status_info,
            'kyc_status' => $kyc_status,
            'nannyKyc' => $kyc_fields
        ];
        $message = ['success' => ['Your KYC info']];
        return ApiResponse::success($message, $data);
    }
    public function kycSubmit(Request $request)
    {
        $user = auth()->user();
        if ($user->kyc_verified == GlobalConst::VERIFIED) {
            $message = ['error' => ['You are already KYC Verified']];
            return ApiResponse::error($message);
        }
        $user_kyc_fields = SetupKyc::nannyKyc()->first()->fields ?? [];

        $validation_rules = $this->generateValidationRules($user_kyc_fields);
        $validated = Validator::make($request->all(), $validation_rules);

        if ($validated->fails()) {
            $message =  ['error' => $validated->errors()->all()];
            return ApiResponse::error($message);
        }
        $validated = $validated->validate();
        $get_values = $this->placeValueWithFields($user_kyc_fields, $validated);
        $create = [
            'nanny_id'       => auth()->user()->id,
            'data'          => json_encode($get_values),
            'created_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            DB::table('nanny_kyc_data')->updateOrInsert(["nanny_id" => $user->id], $create);
            $user->update([
                'kyc_verified'  => GlobalConst::PENDING,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $user->update([
                'kyc_verified'  => GlobalConst::DEFAULT,
            ]);
            $message = ['error' => ['Something went worng! Please try again']];
            return ApiResponse::error($message);
        }

        $service_areas = ServiceArea::get();
        $data = [
            'service_area' => $service_areas,
        ];
        $message = ['success' => ['KYC information successfully submited']];
        return ApiResponse::success($message, $data);
    }
    function professionSubmit(Request $request)
    {

        if ($request->profession_type == '1') {
            $rules = [
                'baby_gender' => 'required',
                'baby_age' => 'required',
                'baby_number' => 'required',

            ];
        } else {
            $rules = [
                'pet_type' => 'required',
                'gender' => 'required',
                'age' => 'required',
                'number' => 'required',
            ];
        }
        $work_work_experience = [
            'work_experience' => 'required',
            'work_capability' => 'required',
            'service_area' => 'required',
            'charge' => 'required',
            'amount' => 'required',
            'bio' => 'required',
        ];
        $total_rules = array_merge($rules, $work_work_experience);

        $validated = Validator::make($request->all(), $total_rules)->validate();



        if ($request->profession_type == '1') {

            $validated['profession_type_details'] = [
                'baby_gender' => $validated['baby_gender'],
                'baby_age' => $validated['baby_age'],
                'baby_number' => $validated['baby_number'],
            ];
        } elseif ($request->profession_type == '2') {

            $validated['profession_type_details'] = [
                'pet_type' => $validated['pet_type'],
                'gender' => $validated['gender'],
                'age' => $validated['age'],
                'number' => $validated['number'],
            ];
        }

        $validated['nanny_id'] = auth()->user()->id;
        $validated['profession_type'] = $request->profession_type;


        try {
            DB::beginTransaction();
            $profession = NannyProfession::create($validated);
            $nanny_id = auth()->user()->id;
            $profession = NannyProfession::where('nanny_id', $nanny_id)->first();
            if ($profession) {
                $nanny = Nanny::findOrFail($nanny_id);
                $nanny->update([
                    'profession_submitted' => 1,
                ]);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $error = ['error' => ['Something went worng! Please try again']];
            return ApiResponse::error($error);
        }

        $message =  ['success' => ['Profession submited successful']];

        return ApiResponse::success($message, $profession);
    }
}
