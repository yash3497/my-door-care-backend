<?php

namespace App\Http\Controllers\Nanny;

use Exception;

use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Models\Admin\SetupKyc;
use Illuminate\Support\Carbon;
use App\Models\NannyAuthorization;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\ServiceArea;
use App\Models\Nanny;
use App\Models\NannyProfession;
use App\Traits\ControlDynamicInputFields;
use Illuminate\Support\Facades\Validator;
use App\Providers\Admin\BasicSettingsProvider;

use Illuminate\Validation\ValidationException;
use App\Notifications\User\Auth\SendAuthorizationCode;
use ParagonIE\Sodium\Compat;

class AuthorizationController extends Controller
{
    use ControlDynamicInputFields;
    public function showMailFrom($token)
    {
        $page_title = setPageTitle("Mail Authorization");

        $user_authorize = NannyAuthorization::where("token", $token)->first();
        $resend_time = 0;
        if (Carbon::now() <= $user_authorize->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE)) {
            $resend_time = Carbon::now()->diffInSeconds($user_authorize->created_at->addMinutes(GlobalConst::USER_PASS_RESEND_TIME_MINUTE));
        }

        return view('nanny.auth.authorize.verify-mail', compact("page_title", "token", "resend_time"));
    }

    public function mailVerify(Request $request, $token)
    {
        $request->merge(['token' => $token]);
        $request->validate([
            'token'     => "required|string|exists:nanny_authorizations,token",
            'code'      => "required|array",
            'code.*'      => "required|integer",
        ]);
        $request->merge(['code' => implode("", $request->code)]);
        if (!NannyAuthorization::where("code", $request->code)->exists()) {
            throw ValidationException::withMessages([
                'code'         => "Invalid OTP. Please try again",
            ]);
        }
        $otp_exp_sec = BasicSettingsProvider::get()->otp_exp_seconds ?? GlobalConst::DEFAULT_TOKEN_EXP_SEC;
        $auth_column = NannyAuthorization::where("token", $request->token)->where("code", $request->code)->first();
        if ($auth_column->created_at->addSeconds($otp_exp_sec) < now()) {
            $this->authLogout($request);
            return redirect()->route('nanny.login')->with(['error' => ['Session expired. Please try again']]);
        }
        try {
            $auth_column->nanny->update([
                'email_verified'    => true,
            ]);
            $auth_column->delete();
        } catch (Exception $e) {
            $this->authLogout($request);
            return redirect()->route('nanny.login')->with(['error' => ['Something went wrong! Please try again']]);
        }
        return redirect()->intended(route("nanny.authorize.kyc"))->with(['success' => ['Please submit KYC information']]);
    }
    public function resendCode()
    {
        $user = auth()->user();
        $resend = NannyAuthorization::where("nanny_id", $user->id)->first();
        if (Carbon::now() <= $resend->created_at->addMinutes(GlobalConst::USER_VERIFY_RESEND_TIME_MINUTE)) {
            throw ValidationException::withMessages([
                'code'      => 'You can resend verification code after ' . Carbon::now()->diffInSeconds($resend->created_at->addMinutes(GlobalConst::USER_VERIFY_RESEND_TIME_MINUTE)) . ' seconds',
            ]);
        }
        $data = [
            'nanny_id'       =>  $user->id,
            'code'          => generate_random_code(),
            'token'         => generate_unique_string("nanny_authorizations", "token", 200),
            'created_at'    => now(),
        ];

        DB::beginTransaction();
        try {
            NannyAuthorization::where("nanny_id", $user->id)->delete();
            DB::table("nanny_authorizations")->insert($data);
            $user->notify(new SendAuthorizationCode((object) $data));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return redirect()->route('nanny.authorize.mail', $data['token'])->with(['success' => ['Varification code resend success!']]);
    }

    public function showKycFrom()
    {
        $user = auth()->user();
        if ($user->kyc_verified == GlobalConst::VERIFIED) return back()->with(['success' => ['You are already KYC Verified User']]);
        $page_title = setPageTitle("KYC Verification");
        $user_kyc = SetupKyc::nannyKyc()->first();
        if (!$user_kyc) return back();
        $kyc_data = $user_kyc->fields;
        $kyc_fields = [];
        if ($kyc_data) {
            $kyc_fields = array_reverse($kyc_data);
        }
        return view('nanny.auth.authorize.verify-kyc', compact("page_title", "kyc_fields"));
    }

    public function kycSubmit(Request $request)
    {

        $user = auth()->user();
        if ($user->kyc_verified == GlobalConst::VERIFIED) return back()->with(['success' => ['You are already KYC Verified User']]);

        $user_kyc_fields = SetupKyc::nannyKyc()->first()->fields ?? [];
        $validation_rules = $this->generateValidationRules($user_kyc_fields);

        $validated = Validator::make($request->all(), $validation_rules)->validate();
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
            $this->generatedFieldsFilesDelete($get_values);
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return redirect()->intended(route('nanny.authorize.profession'))->with(['success' => ['KYC information successfully submited']]);
    }
    function profession()
    {
        $page_title = 'Profession and Experience';
        $service_areas = ServiceArea::get();

        return view('nanny.auth.profession', Compact('page_title', 'service_areas'));
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
        } else {

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
            NannyProfession::create($validated);
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
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }


        return redirect()->route('nanny.dashboard');
    }

    public function showGoogle2FAForm()
    {
        $page_title =  "Authorize Google Two Factor";
        return view('nanny.auth.authorize.verify-google-2fa', compact('page_title'));
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

            return redirect()->intended(route('nanny.dashboard'));
        }

        return back()->with(['warning' => ['Faild to login. Please try again']]);
    }
}
