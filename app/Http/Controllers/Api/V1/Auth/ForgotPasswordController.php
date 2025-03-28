<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\UserPasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Providers\Admin\BasicSettingsProvider;
use App\Http\Helpers\Api\Helpers as ApiResponse;
use App\Notifications\User\Auth\PasswordResetEmail;

class ForgotPasswordController extends Controller
{
    /**
     * Send Verification code to user email/phone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'credentials'   => "required|string|max:100",
        ]);

        if ($validator->fails()) {
            $message =  ['error' => $validator->errors()->all()];
            return ApiResponse::validation($message);
        }

        $column = "username";
        if (check_email($request->credentials)) $column = "email";
        $user = User::where($column, $request->credentials)->first();

        if (!$user) {
            $message =  ['error' => ["User doesn't exists."]];
            return ApiResponse::error($message);
        }

        $token = generate_unique_string("user_password_resets", "token", 80);
        $code = generate_random_code();
        try {
            UserPasswordReset::where("user_id", $user->id)->delete();
            $password_reset = UserPasswordReset::create([
                'user_id'       => $user->id,
                'token'         => $token,
                'code'          => $code,
                'email'      => $request->credentials,
            ]);
            $user->notify(new PasswordResetEmail($user, $password_reset));
        } catch (Exception $e) {
            info($e);
            $message = ['error' =>  ['Something went wrong! Please try again.']];
            return ApiResponse::error($message);
        }
        $data = ['user' => $password_reset];
        $message = ['success' =>  ['Verification otp code sended to your email address.']];
        return ApiResponse::success($message, $data);
    }


    /**
     * OTP Verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyCode(Request $request)
    {
        $token = $request->token;
        $request->merge(['token' => $token]);
        $rules = [
            'token'         => "required|string|exists:user_password_resets,token",
            'otp'          => "required|numeric|exists:user_password_resets,code",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $message =  ['error' => $validator->errors()->all()];
            return ApiResponse::validation($message);
        }

        $basic_settings = BasicSettingsProvider::get();
        $otp_exp_seconds = $basic_settings->otp_exp_seconds ?? 0;

        $password_reset = UserPasswordReset::where("token", $token)->first();
        if (Carbon::now() >= $password_reset->created_at->addSeconds($otp_exp_seconds)) {
            foreach (UserPasswordReset::get() as $item) {
                if (Carbon::now() >= $item->created_at->addSeconds($otp_exp_seconds)) {
                    $item->delete();
                }
            }
            $message = ['error' => ['Session expired. Please try again.']];
            return ApiResponse::error($message);
        }
        if ($password_reset->code != $request->otp) {
            $message = ['error' => ['Verification OTP invalid']];
            return ApiResponse::error($message);
        }
        $data = ['password_reset_data' => $password_reset];
        $message = ['success' => ['OTP verification successful']];
        return ApiResponse::success($message, $data);
    }

    /**
     * Password Reset.
     *
     * @method POST
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        if ($request->password != $request->password_confirmation) {
            $message = ['error' => ['Oops password does not match.']];
            return ApiResponse::error($message);
        }

        $token = $request->token;
        $basic_settings = BasicSettingsProvider::get();
        $password_rule = "required|string|min:6|confirmed";

        if ($basic_settings->secure_password) {
            $password_rule = ["required", Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(), "confirmed"];
        }
        $request->merge(['token' => $token]);
        $rules = [
            'token'         => "required|string|exists:user_password_resets,token",
            'password'      => $password_rule,
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $message =  ['error' => $validator->errors()->all()];
            return ApiResponse::error($message);
        }


        $password_reset = UserPasswordReset::where("token", $token)->first();
        if (!$password_reset) {
            $message = ['error' => ['Invalid Request. Please try again']];
            return ApiResponse::success($message);
        }
        try {
            $password_reset->user->update(['password' => Hash::make($request->password)]);
            $password_reset->delete();
        } catch (Exception $e) {
            $message = ['error' => ['Something went wrong! Please try again.']];
            return ApiResponse::success($message);
        }
        $message = ['success' => ['Password reset success. Please login with new password.']];
        return ApiResponse::onlysuccess($message);
    }
}
