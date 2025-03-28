<?php

namespace App\Http\Controllers\Api\V1\Nanny\Auth;


use Exception;

use App\Models\Nanny;
use Illuminate\Http\Request;
use App\Models\NannyAuthorization;
use App\Traits\User\LoggedInUsers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\User\RegisteredUsers;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Providers\Admin\BasicSettingsProvider;
use App\Http\Helpers\Api\Helpers as ApiResponse;
use App\Notifications\Nanny\Auth\SendAuthorizationCode;


class AuthController extends Controller
{
    // use LoggedInUsers, RegisteredUsers;
    protected $basic_settings;

    public function __construct()
    {
        return $this->basic_settings = BasicSettingsProvider::get();
    }
    /**
     * Mehtod for user login
     * @method POST
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Request  Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:40',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            $error = ['error' => $validator->errors()->all()];
            return ApiResponse::validation($error);
        }

        $user = Nanny::where('username', trim(strtolower($request->email)))
            ->orWhere('email', $request->email)->first();

        if (!$user) {
            $error = ['error' => ['The credentials does not match']];
            return ApiResponse::validation($error);
        }
        $user->two_factor_verified = false;
        $user->save();

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $user_data = [
            'token' => $token,
            'image_path' => get_files_public_path('user-profile'),
            'default_image' => get_files_public_path('default'),
            'nanny' => new UserResource($user)
        ];

        if (Hash::check($request->password, $user->password)) {
            if ($user->status == 0) {
                $error = ['error' => ['Account Has been Suspended']];
                return ApiResponse::validation($error);
            } elseif ($user->email_verified == 0) {
                $user_authorize = NannyAuthorization::where("nanny_id", $user->id)->first();
                $resend_code = generate_random_code();
                $user_authorize->update([
                    'code'          => $resend_code,
                    'created_at'    => now(),
                ]);
                $data = $user_authorize->toArray();
                $user->notify(new SendAuthorizationCode((object) $data));
                $message = ['success' => ['Please check email and verify your account']];
                return ApiResponse::success($message, $user_data);
            }


            $message = ['success' => ['Login Successfull']];
            return ApiResponse::success($message, $user_data);
        } else {
            $error = ['error' => ['The credentials does not match']];
            return ApiResponse::error($error);
        }
    }

    public function register(Request $request)
    {
        $basic_settings = $this->basic_settings;
        $passowrd_rule = "required|string|min:6";

        if ($basic_settings->secure_password) {
            $passowrd_rule = ["required", Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()];
        }

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:50',
            'lastname'  => 'required|string|max:50',
            'email'     => 'required|email|max:160|unique:nannies',
            'mobile'    => 'required|max:50',
            'country'   => 'required|string',
            'password'  => $passowrd_rule,
        ]);

        if ($validator->fails()) {
            $error =  ['error' => $validator->errors()->all()];
            return ApiResponse::validation($error);
        }

        $validated = $validator->validated();


        //User Create
        $validated['firstname']      = $validated['firstname'];
        $validated['lastname']       = $validated['lastname'];
        $validated['email_verified'] = ($basic_settings->email_verification == true) ? 0 : 1;
        $validated['kyc_verified']   = 0;
        $validated['sms_verified']   = 0;
        $validated['status']         = 1;
        $validated['password']       = Hash::make($validated['password']);
        $validated['username']       = make_username($validated['firstname'], $validated['lastname']);
        $validated['address']       = [
            'country'   => $validated['country'] ?? "",
            'city'   => '',
            'state'   => '',
            'zip'   => '',
            'address'   => '',
        ];
        $validated['profession_submitted'] = 0;


        $user = Nanny::create($validated);

        $user->two_factor_verified = false;
        $user->save();
        $token = $user->createToken('Nanny Registration')->accessToken;

        if ($basic_settings->email_verification == true) {
            $data = [
                'nanny_id'       => $user->id,
                'code'          => generate_random_code(),
                'token'         => generate_unique_string("nanny_authorizations", "token", 5),
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
                $error = ['error' => ['Something went worng! Please try again']];
                return ApiResponse::error($error);
            }
        }

        if ($basic_settings->email_verification == 1 && $basic_settings->email_notification == 1) {
            $message =  ['success' => ['Please check email and verify your account']];
        } else {
            $message =  ['success' => ['Registration successful']];
        }


        $data = [
            'token' => $token,
            'base_url' => url('/'),
            'image_path' => get_files_public_path('nanny-profile'),
            'default_image' => get_files_public_path('default'),
            'nanny' => new UserResource($user)
        ];
        return ApiResponse::success($message, $data);
    }
}
