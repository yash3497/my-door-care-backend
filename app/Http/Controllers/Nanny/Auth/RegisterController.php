<?php

namespace App\Http\Controllers\Nanny\Auth;

use App\Models\Nanny;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Providers\Admin\BasicSettingsProvider;
use App\Traits\Nanny\RegisteredNannies;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers, RegisteredNannies;

    protected $basic_settings;

    public function __construct()
    {
        $this->basic_settings = BasicSettingsProvider::get();
    }
    function showRegistrationForm()
    {
        $page_title = "Nanny Registration";
        return view('nanny.auth.register', compact('page_title'));
    }
    public function register(Request $request)
    {

        $validated = $this->validator($request->all())->validate();
        $validated['address']       = [
            'country'   => $validated['country'] ?? "",
            'city'   => '',
            'state'   => '',
            'zip'   => '',
            'address'   => '',
        ];

        $basic_settings                 = $this->basic_settings;
        $validated['email_verified']    = ($basic_settings->email_verification == true) ? false : true;
        $validated['sms_verified']      = ($basic_settings->sms_verification == true) ? false : true;
        $validated['kyc_verified']      = ($basic_settings->kyc_verification == true) ? false : true;
        $validated['password']          = Hash::make($validated['password']);
        $validated['username']          = make_username($validated['firstname'], $validated['lastname']);

        event(new Registered($user = $this->create($validated)));
        $this->guard()->login($user);

        $email = $request->email;
        session(['email' => $email]);

        return $this->registered($request, $user);
    }


    /**
     *
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {

        $basic_settings = $this->basic_settings;
        $passowrd_rule = "required|string|min:6";

        if ($basic_settings->secure_password) {
            $passowrd_rule = ["required", Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()];
        }

        return Validator::make($data, [
            'firstname'     => 'required|string|max:60',
            'lastname'      => 'string|max:60',
            'mobile'         => "required|string",
            'country'       => "required|string|max:50",
            'email'         => 'required|string|email|max:150|unique:nannies,email',
            'password'      => $passowrd_rule,

        ]);
    }

    protected function guard()
    {
        return Auth::guard("nanny");
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        return Nanny::create($data);
    }


    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $nanny)
    {
        $this->createNannyWallets($nanny);
        return redirect()->intended(route('nanny.dashboard'));
    }
}
