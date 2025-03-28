<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Admin\SetupKyc;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Providers\Admin\BasicSettingsProvider;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "User Profile";
        $kyc_data = SetupKyc::userKyc()->first();
        return view('user.sections.profile.index', compact("page_title", "kyc_data"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'firstname'     => "required|string|max:60",
            'city'          => "required|string|max:50",
            'lastname'     => "nullable|string|max:60",
            'mobile'        => "nullable|string",
            'country'       => "nullable|string|max:50",
            'state'         => "nullable|string|max:50",
            'address'       => "nullable|string|max:250",
            'zip_code'      => "nullable|max:50",
            'image'         => "nullable|image|mimes:jpg,png,svg,webp|max:10240",
        ])->validate();


        $validated['address']       = [
            'country'   => $validated['country'] ?? "",
            'state'     => $validated['state'] ?? "",
            'city'      =>  $validated['city'],
            'zip'       => $validated['zip_code'] ?? "",
            'address'   => $validated['address'] ?? "",
        ];


        if ($request->hasFile("image")) {
            $image = upload_file($validated['image'], 'user-profile', auth()->user()->image);
            $upload_image = upload_files_from_path_dynamic([$image['dev_path']], 'user-profile');
            delete_file($image['dev_path']);
            $validated['image']     = $upload_image;
        }



        try {
            auth()->user()->update($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }

        return back()->with(['success' => ['Profile successfully updated!']]);
    }

    function passwordChangeForm()
    {
        return view('user.sections.password-change.index');
    }

    public function passwordUpdate(Request $request)
    {

        $basic_settings = BasicSettingsProvider::get();
        $passowrd_rule = "required|string|min:6|confirmed";
        if ($basic_settings->secure_password) {
            $passowrd_rule = ["required", Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(), "confirmed"];
        }

        $request->validate([
            'current_password'      => "required|string",
            'password'              => $passowrd_rule,
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            throw ValidationException::withMessages([
                'current_password'      => 'Current password didn\'t match',
            ]);
        }

        try {
            auth()->user()->update([
                'password'  => Hash::make($request->password),
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again.']]);
        }

        return back()->with(['success' => ['Password successfully updated!']]);
    }

    public function accountDelete($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => 0,
            'email_verified' => 0,
            'sms_verified' => 0,
        ]);
        return redirect()->route('index');
    }
}
