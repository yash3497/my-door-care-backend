<?php

namespace App\Http\Controllers\Nanny;

use Exception;

use App\Models\Nanny;
use App\Models\Review;
use App\Models\UserRequest;
use App\Models\NannyKycData;

use Illuminate\Http\Request;
use App\Models\NannyProfession;
use App\Models\Admin\ServiceArea;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Providers\Admin\BasicSettingsProvider;
use Illuminate\Validation\ValidationException;

class NannyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = "Nanny Profile";
        $service_areas = ServiceArea::get();
        $nanny_id = auth()->user()->id;
        $profession = NannyProfession::where('nanny_id', $nanny_id)->first();
        $average_rating = ceil(Review::pluck('rating')->sum() / 5);
        $completed_work = UserRequest::where('nanny_id', $nanny_id)->whereIn('status', [4, 5, 6])->count();

        return view('nanny.profile.index', compact("page_title", "service_areas", "profession", "average_rating", "completed_work"));
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
            'email'         => "required|email",
            'mobile'         => "required|string",
            'country'       => "required|string|max:50",
            'lastname'     => "nullable|string|max:60",
            'city'          => "nullable|string|max:50",
            'state'         => "nullable|string|max:50",
            'address'       => "nullable|string|max:250",
            'zip_code'      => "nullable|max:50",
            'image'         => "nullable|image|mimes:jpg,png,svg,webp|max:10240",
        ])->validate();

        $validated['address']       = [
            'country'   => $validated['country'] ?? "",
            'state'     => $validated['state'] ?? "",
            'city'      => $validated['city'] ?? "",
            'zip'       => $validated['zip_code'] ?? "",
            'address'   => $validated['address'] ?? "",
        ];

        if ($request->hasFile("image")) {
            $image = upload_file($validated['image'], 'nanny-profile', auth()->user()->image);
            $upload_image = upload_files_from_path_dynamic([$image['dev_path']], 'nanny-profile');
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
        return view('nanny.sections.password-change.index');
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
            return back()->with(['error' => ['Something went wrong! Please try again.']]);
        }

        return redirect()->route('nanny.login')->with(['success' => ['Password successfully updated!']]);
    }

    function professionUpdate(Request $request)
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

            $nanny_id =  auth()->user()->id;
            $profession = NannyProfession::where('nanny_id', $nanny_id)->first();
            $profession->update($validated);
        } catch (Exception $e) {

            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }
        return back()->with(['success' => ['Profession updated successfully']]);
    }

    public function accountDelete($id)
    {
        $user = Nanny::findOrFail($id);
        $user->update([
            'status' => 0,
            'email_verified' => 0,
            'sms_verified' => 0,
            'kyc_verified' => 0,
            'profession_submitted' => 0
        ]);
        return redirect()->route('index');
    }

    public function kyc()
    {
        $page_title = "KYC";
        $nanny_kyc_data = NannyKycData::auth()->first();
        $nanny = auth()->user();

        return view('nanny.sections.kyc.index', compact('nanny_kyc_data', 'nanny'));
    }
}
