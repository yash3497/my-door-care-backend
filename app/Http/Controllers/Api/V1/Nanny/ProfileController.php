<?php

namespace App\Http\Controllers\Api\V1\Nanny;

use Exception;

use App\Models\Nanny;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\NannyProfession;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use GuzzleHttp\Psr7\Request as Psr7Request;
use App\Providers\Admin\BasicSettingsProvider;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class ProfileController extends Controller
{
    /**
     * Profile Get Data
     *
     * @method GET
     * @return \Illuminate\Http\Response
     */

    public function profile()
    {
        $user = Nanny::where('id', Auth::user()->id)->get()->map(function ($data) {
            $address = [
                'country' => $data->address->country ?? '',
                'city' => $data->address->city ?? '',
                'state' => $data->address->state ?? '',
                'zip' => $data->address->zip ?? '',
                'address' => $data->address->address ?? '',
            ];
            return [
                'id' => $data->id,
                'firstname' => $data->firstname,
                'lastname' => $data->lastname,
                'status' => $data->status,
                'email' => $data->email,
                'address' => (object)$address,
                'email' => $data->email,
                'mobile_code' => $data->mobile_code,
                'mobile' => $data->mobile,
                'username' => $data->username,
                'full_mobile' => $data->full_mobile,
                'image' => $data->image,
                'ver_code' => $data->ver_code,
                'ver_code_send_at' => $data->ver_code_send_at,
                'email_verified_at' => $data->email_verified_at,
                'email_verified' => $data->email_verified,
                'sms_verified' => $data->sms_verified,
                'profession_submitted' => $data->profession_submitted,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
                'kyc_verified' => $data->kyc_verified,
            ];
        })->first();
        $data = [
            'base_url' => url(''),
            'default_image' => "public/backend/images/default/profile-default.webp",
            "image_path"    => "public/frontend/nanny",
            'nanny'          => (object)$user,
        ];

        $message =  ['success' => [__('User Profile')]];

        return ApiResponse::success($message, $data);
    }
    /**
     * Profile Update
     *
     * @method POST
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname'     => "required|string|max:60",
            'lastname'      => "required|string|max:60",
            'image'         => "nullable|image|mimes:jpg,png,svg,webp|max:10240",
            'country'       => "required|string|max:50",
            'phone'         => "required|numeric",
            'state'         => "nullable|string|max:50",
            'city'          => "nullable|string|max:50",
            'address'       => "nullable|string|max:250",
            'zip_code'      => "nullable",
        ]);

        $user = auth()->user();

        if ($validator->fails()) {
            $error = ['error' => [$validator->errors()->all()]];
            return ApiResponse::validation($error);
        }

        $validated = $validator->validated();

        $validated['mobile']        = remove_speacial_char($validated['phone']);

        $validated                  = Arr::except($validated, ['agree', 'phone_code', 'phone']);
        $validated['address']       = [
            'country'   => $validated['country'] ?? "",
            'state'     => $validated['state'] ?? "",
            'city'      => $validated['city'] ?? "",
            'zip'       => $validated['zip_code'] ?? "",
            'address' => $validated['address'],
        ];

        if ($request->hasFile('image')) {

            if ($user->image == null) {
                $oldImage = null;
            } else {
                $oldImage = $user->image;
            }

            $image = upload_file($validated['image'], 'nanny-profile', $oldImage);
            $upload_image = upload_files_from_path_dynamic([$image['dev_path']], 'nanny-profile');
            delete_file($image['dev_path']);
            $validated['image']     = $upload_image;
        }

        try {
            $user->update($validated);
        } catch (\Throwable $th) {
            $error = ['error' => [__('Something went wrong! Please try again')]];
            return ApiResponse::error($error);
        }

        $message =  ['success' => [__('Profile successfully updated!')]];
        return ApiResponse::onlysuccess($message);
    }


    public function passwordUpdate(Request $request)
    {
        $basic_settings = BasicSettingsProvider::get();

        $passowrd_rule = 'required|string|min:6|confirmed';

        if ($basic_settings->secure_password) {
            $passowrd_rule = ["required", Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(), "confirmed"];
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|min:6',
            'password' => $passowrd_rule,
        ]);

        if ($validator->fails()) {
            $error =  ['error' => $validator->errors()->all()];
            return ApiResponse::validation($error);
        }

        $validated = $validator->validate();

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            $message = ['error' =>  ['Current password didn\'t match']];
            return ApiResponse::error($message);
        }
        try {
            Auth::user()->update(['password' => Hash::make($validated['password'])]);
            $message = ['success' =>  [__('Password updated successfully!')]];
            return ApiResponse::onlysuccess($message);
        } catch (Exception $ex) {
            info($ex);
            $message = ['error' =>  [__('Something went wrong! Please try again.!')]];
            return ApiResponse::error($message);
        }
    }

    public function accountDelete()
    {
        $user = Auth::user();
        $user->update([
            'status' => 0,
            'email_verified' => 0,
            'kyc_verified' => 0,
            'profession_submitted' => 0,
        ]);
        $message =  ['success' => [__('Account Delete successfully!')]];
        return ApiResponse::onlysuccess($message);
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
            'target' => 'required',
        ];
        $total_rules = array_merge($rules, $work_work_experience);

        $validator = Validator::make($request->all(), $total_rules);

        if ($validator->fails()) {
            $error = ['error' => [$validator->errors()->all()]];
            ApiResponse::validation($error);
        }
        $validated = $validator->validate();

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
            $profession_id = $request->target;
            $profession_id = NannyProfession::findOrFail($profession_id);
            $profession_id->update($validated);
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
        $message =  ['success' => ['Profession Update Successful']];
        return ApiResponse::onlysuccess($message);
    }

    function profession()
    {
        $nanny_id = auth()->user()->id;
        $profession = NannyProfession::where('nanny_id', $nanny_id)->first();

        $age = [
            'o - 6 Months',
            '6 Months - 1 Year',
            '1 Year - 1.5 Years',
            '1.5 Years - 2 Years',
            '2 Years - 3 Years',
            '3 Years - 4 Years',
            '5 Years - 6 Years',
            '6+ Years',
        ];
        $gender = [
            'Male',
            'Female',
            'Other',

        ];
        $number = [
            'Single',
            'Multiple',
        ];
        $pet_type = [
            'Cat',
            'Dog',
            'Bird',
            'Horse',
            'Rabbit',

        ];
        $word_capability = [
            '12 - 24 Hours',
            '2 Days',
            '3 Days',
            '5 Days',
            '1 Week',
            '2 Weeks',
            '1 Month',

        ];
        $charge_type = [
            'Hourly',
            'Daily',
            'Weekly',
            'Monthly',
        ];

        $data = [
            'base_url' => url(''),
            'age' => $age,
            'gender' => $gender,
            'number' => $number,
            'pet_type' => $pet_type,
            'word_capability' => $word_capability,
            'charge_type' => $charge_type,
            'default_currency' => [get_default_currency_code()],
            "image_path"    => "public/frontend/nanny",
            'nanny'          => (object)$profession,
        ];

        $message =  ['success' => [__('Nanny Profession')]];

        return ApiResponse::success($message, $data);
    }
}
