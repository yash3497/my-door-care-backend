<?php

namespace App\Http\Controllers\Api\V1\User;

use Exception;
use App\Models\AddBabyPat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\Api\Helpers as ApiResponse;

class AddBabyPetController extends Controller
{
    function myBabyPet()
    {
        $my_baby = AddBabyPat::auth()->where('profession_type', 1)->get()->map(function ($data) {

            $my_baby = [
                'baby_name' => $data->profession_type_details->baby_name ?? '',
                'baby_gender' => $data->profession_type_details->baby_gender ?? '',
                'baby_age' => $data->profession_type_details->baby_age ?? '',
                'baby_food' => $data->profession_type_details->baby_food ?? '',


            ];

            return [
                'id' => $data->id,
                'user_id' => $data->user_id,
                'image' => $data->image,
                'profession_type' => $data->profession_type,
                'profession_type_details' => (object) $my_baby
            ];
        });
        $my_pet = AddBabyPat::auth()->where('profession_type', 2)->get()->map(function ($data) {




            $my_pet = [
                'pet_name' => $data->profession_type_details->pet_name ?? '',
                'pet_type' => $data->profession_type_details->pet_type ?? '',
                'pet_breed' => $data->profession_type_details->pet_breed ?? '',
                'pet_age' => $data->profession_type_details->pet_age ?? '',
                'pet_weight' => $data->profession_type_details->pet_weight ?? '',
                'pet_gender' => $data->profession_type_details->pet_gender ?? '',
                'pet_food' => $data->profession_type_details->pet_food ?? '',


            ];
            return [
                'id' => $data->id,
                'user_id' => $data->user_id,
                'image' => $data->image,
                'profession_type' => $data->profession_type,
                'profession_type_details' => (object) $my_pet
            ];
        });

        $gender = ['Male', 'Female', 'Other'];
        $petType = [
            'Cat',
            'Dog',
            'Bird',
            'Horse',
            'Rabbit',
        ];
        $data = [
            'base_url'      => url('/'),
            'default_image' => "public/backend/images/default/profile-default.webp",
            "image_path"    => "public/frontend/images/add-baby-pet",
            'my_baby'       => (object)$my_baby,
            'my_pet'        => (object)$my_pet,
            'gender'        => (object)$gender,
            'petType'       => (object)$petType,

        ];


        $message =  ['success' => [__('My Baby/Pet list')]];

        return ApiResponse::success($message, $data);
    }
    function store(Request $request)
    {
        if ($request->profession_type == 1) {
            $rules = [
                'baby_name' => 'required',
                'baby_gender' => 'required',
                'baby_age' => 'required',
                'baby_food' => 'required',
                'image' => 'nullable|image|mimes:jpg,png,svg,webp|max:10240'
            ];
        } elseif ($request->profession_type == 2) {
            $rules = [
                'pet_name' => 'required',
                'pet_type' => 'required',
                'pet_breed' => 'required',
                'pet_age' => 'required',
                'pet_weight' => 'required',
                'pet_gender' => 'required',
                'pet_food' => 'required',
                'image' => 'nullable|image|mimes:jpg,png,svg,webp|max:10240'
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $error = ['error' => [$validator->errors()->all()]];
            return ApiResponse::validation($error);
        }
        $validated = $validator->validated();

        if ($request->hasFile("image")) {
            $image = upload_file($validated['image'], 'add-baby-pet', auth()->user()->image);
            $upload_image = upload_files_from_path_dynamic([$image['dev_path']], 'add-baby-pet');
            delete_file($image['dev_path']);
            $validated['image']     = $upload_image;
        }

        if ($request->profession_type == 1) {
            $validated['profession_type_details'] = [
                'baby_name' => $validated['baby_name'],
                'baby_gender' => $validated['baby_gender'],
                'baby_age' => $validated['baby_age'],
                'baby_food' => $validated['baby_food'],
            ];
        } elseif ($request->profession_type == 2) {
            $validated['profession_type_details'] = [
                'pet_name' => $validated['pet_name'],
                'pet_type' => $validated['pet_type'],
                'pet_breed' => $validated['pet_breed'],
                'pet_gender' => $validated['pet_gender'],
                'pet_age' => $validated['pet_age'],
                'pet_weight' => $validated['pet_weight'],
                'pet_food' => $validated['pet_food'],
            ];
        }

        $validated['user_id'] = auth()->user()->id;
        $validated['profession_type'] = $request->profession_type;

        try {
            $addBabyPet = AddBabyPat::create($validated);
        } catch (Exception $e) {

            $error = ['error' => [__('Something went wrong! Please try again')]];
            return ApiResponse::error($error);
        }
        $message = ['success' => [__('Create Successfully!')]];
        return ApiResponse::success($message, $addBabyPet);
    }
    function update(Request $request)
    {
        if ($request->profession_type == 1) {
            $rules = [
                'target' => 'required',
                'baby_name' => 'required',
                'baby_gender' => 'required',
                'baby_age' => 'required',
                'baby_food' => 'required',
                'image' => 'nullable|image|mimes:jpg,png,svg,webp|max:10240'
            ];
        } elseif ($request->profession_type == 2) {
            $rules = [
                'target' => 'required',
                'pet_name' => 'required',
                'pet_type' => 'required',
                'pet_breed' => 'required',
                'pet_age' => 'required',
                'pet_weight' => 'required',
                'pet_gender' => 'required',
                'pet_food' => 'required',
                'image' => 'nullable|image|mimes:jpg,png,svg,webp|max:10240'
            ];
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $error = ['error' => [$validator->error()->all()]];
            return ApiResponse::validation($error);
        }
        $validated = $validator->validated();

        if ($request->hasFile("image")) {
            $image = upload_file($validated['image'], 'add-baby-pet', auth()->user()->image);
            $upload_image = upload_files_from_path_dynamic([$image['dev_path']], 'add-baby-pet');
            delete_file($image['dev_path']);
            $validated['image']     = $upload_image;
        }


        if ($request->profession_type == 1) {
            $validated['profession_type_details'] = [
                'baby_name' => $validated['baby_name'],
                'baby_gender' => $validated['baby_gender'],
                'baby_age' => $validated['baby_age'],
                'baby_food' => $validated['baby_food'],
            ];
        } elseif ($request->profession_type == 2) {
            $validated['profession_type_details'] = [
                'pet_name' => $validated['pet_name'],
                'pet_type' => $validated['pet_type'],
                'pet_breed' => $validated['pet_breed'],
                'pet_gender' => $validated['pet_gender'],
                'pet_age' => $validated['pet_age'],
                'pet_weight' => $validated['pet_weight'],
                'pet_food' => $validated['pet_food'],
            ];
        }

        $validated['user_id'] = auth()->user()->id;
        $validated['profession_type'] = $request->profession_type;

        $add_baby_pet_id = $request->target;



        try {
            $add_baby_pet_id = AddBabyPat::findOrFail($add_baby_pet_id);
            $add_baby_pet_id->update($validated);
        } catch (Exception $e) {

            $error = ['error' => [__('Something went wrong! Please try again')]];
            return ApiResponse::error($error);
        }
        $message = ['success' => ['Profession updated successfully']];
        return ApiResponse::onlysuccess($message);
    }

    function delete(Request $request)
    {
        $add_baby_pet_id = $request->target;
        try {
            $add_baby_pet_id = AddBabyPat::findOrFail($add_baby_pet_id);
            $add_baby_pet_id->delete();
        } catch (Exception $e) {
            $error = ['error' => [__('Something went wrong! Please try again')]];
            return ApiResponse::error($error);
        }
        $message = ['success' => [__('Deleteed Successfully')]];
        return ApiResponse::onlysuccess($message);
    }
}
