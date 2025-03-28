<?php

namespace App\Http\Controllers\User;

use Exception;
use Carbon\Carbon;
use App\Models\UserKycData;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Models\Admin\SetupKyc;
use App\Models\UserAuthorization;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\ControlDynamicInputFields;
use Illuminate\Support\Facades\Validator;
use App\Providers\Admin\BasicSettingsProvider;
use Illuminate\Validation\ValidationException;
use App\Notifications\User\Auth\SendAuthorizationCode;

class AuthorizationController extends Controller
{
    use ControlDynamicInputFields;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMailFrom($token)
    {
        $page_title = setPageTitle("Mail Authorization");

        $user_authorize = UserAuthorization::where("token", $token)->first();
        $resend_time = 0;
        if (Carbon::now() <= $user_authorize->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE)) {
            $resend_time = Carbon::now()->diffInSeconds($user_authorize->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE));
        }

        return view('user.auth.authorize.verify-mail', compact("page_title", "token", "resend_time"));
    }


    public function mailResend($token)
    {
        $user_authorize = UserAuthorization::where("token", $token)->first();
        if (!$user_authorize) return back()->with(['error' => ['Request token is invalid']]);
        if (Carbon::now() <= $user_authorize->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE)) {
            throw ValidationException::withMessages([
                'code'      => 'You can resend verification code after ' . Carbon::now()->diffInSeconds($user_authorize->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE)) . ' seconds',
            ]);
        }
        $resend_code = generate_random_code();
        try {
            $user_authorize->update([
                'code'          => $resend_code,
                'created_at'    => now(),
            ]);
            $data = $user_authorize->toArray();
            $user_authorize->user->notify(new SendAuthorizationCode((object) $data));
        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'code'      => "Something went wrong! Please try again.",
            ]);
        }
        return redirect()->route('user.authorize.mail', $token)->with(['success' => ['Mail Resend Success!']]);
    }

    public function mailVerify(Request $request, $token)
    {
        $request->merge(['token' => $token]);
        $request->validate([
            'token'     => "required|string|exists:user_authorizations,token",
            'code'      => "required|array",
            'code.*'      => "required|integer",
        ]);
        $request->merge(['code' => implode("", $request->code)]);
        if (!UserAuthorization::where("code", $request->code)->exists()) {
            throw ValidationException::withMessages([
                'code'         => "Invalid OTP. Please try again",
            ]);
        }
        $otp_exp_sec = BasicSettingsProvider::get()->otp_exp_seconds ?? GlobalConst::DEFAULT_TOKEN_EXP_SEC;
        $auth_column = UserAuthorization::where("token", $request->token)->where("code", $request->code)->first();
        if ($auth_column->created_at->addSeconds($otp_exp_sec) < now()) {
            $this->authLogout($request);
            return redirect()->route('user.login')->with(['error' => ['Session expired. Please try again']]);
        }
        try {
            $auth_column->user->update([
                'email_verified'    => true,
            ]);
            $auth_column->delete();
        } catch (Exception $e) {
            $this->authLogout($request);
            return redirect()->route('user.login')->with(['error' => ['Something went wrong! Please try again']]);
        }
        return redirect()->intended(route("user.dashboard"))->with(['success' => ['Account successfully verified']]);
    }

    public function authLogout(Request $request)
    {
        auth()->guard("web")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function showKycFrom()
    {
        $user = auth()->user();
        if ($user->kyc_verified == GlobalConst::VERIFIED) return back()->with(['success' => ['You are already KYC Verified User']]);
        $page_title = setPageTitle("KYC Verification");
        $user_kyc = SetupKyc::userKyc()->first();
        if (!$user_kyc) return back();
        $kyc_data = $user_kyc->fields;
        $kyc_fields = [];
        if ($kyc_data) {
            $kyc_fields = array_reverse($kyc_data);
        }
        return view('user.auth.authorize.verify-kyc', compact("page_title", "kyc_fields"));
    }

    public function kycSubmit(Request $request)
    {

        $user = auth()->user();
        if ($user->kyc_verified == GlobalConst::VERIFIED) return back()->with(['success' => ['You are already KYC Verified User']]);

        $user_kyc_fields = SetupKyc::userKyc()->first()->fields ?? [];
        $validation_rules = $this->generateValidationRules($user_kyc_fields);

        $validated = Validator::make($request->all(), $validation_rules)->validate();
        $get_values = $this->placeValueWithFields($user_kyc_fields, $validated);

        $create = [
            'user_id'       => auth()->user()->id,
            'data'          => json_encode($get_values),
            'created_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            DB::table('user_kyc_data')->updateOrInsert(["user_id" => $user->id], $create);
            $user->update([
                'kyc_verified'  => GlobalConst::PENDING,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $user->update([
                'kyc_verified'  => GlobalConst::DEFAULT,
            ]);
            $this->generatedFieldsFilesDelete($get_values);
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return redirect()->route("user.profile.index")->with(['success' => ['KYC information successfully submited']]);
    }

    public function showGoogle2FAForm()
    {
        $page_title =  "Authorize Google Two Factor";
        return view('user.auth.authorize.verify-google-2fa', compact('page_title'));
    }

    public function google2FASubmit(Request $request)
    {


        $request->validate([
            'code'      => "required|array",
            'code.*'    => "required|numeric",
        ]);
        $code = $request->code;
        $code = implode("", $code);

        $user = auth()->user();

        if (!$user->two_factor_secret) {
            return back()->with(['warning' => ['Your secret key not stored properly. Please contact with system administrator']]);
        }

        if (google_2fa_verify($user->two_factor_secret, $code)) {

            $user->update([
                'two_factor_verified'   => true,

            ]);

            return redirect()->intended(route('user.dashboard'));
        }

        return back()->with(['warning' => ['Faild to login. Please try again']]);
    }
}
