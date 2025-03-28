<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AddBabyPat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddBabyPetController extends Controller
{
    function index()
    {
        $user_id = auth()->user()->id;
        $baby_pets = AddBabyPat::where('user_id', $user_id)->orderBy('id', 'DESC')->limit(6)->get();
        return view('user.sections.add-baby-pet.index', compact('baby_pets'));
    }

    function create()
    {
        return view('user.sections.add-baby-pet.create');
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
        $validated = Validator::make($request->all(), $rules)->validated();

        if ($request->hasFile("image")) {

            $image = get_files_from_fileholder($request, 'image');
            $upload_image = upload_files_from_path_static($image, 'add-baby-pet', null, true, true);
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
            AddBabyPat::create($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }
        return redirect()->route('user.add.baby.pet.index')->with(['success' => ['Profession updated successfully']]);
    }

    function edit($id)
    {
        $baby_pet = AddBabyPat::findOrFail($id);
        return view('user.sections.add-baby-pet.edit', compact('baby_pet'));
    }
    function update(Request $request, $id)
    {
        $add_baby_pet_id = AddBabyPat::findOrFail($id);

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
        $validated = Validator::make($request->all(), $rules)->validated();

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
            $add_baby_pet_id->update($validated);
        } catch (Exception $e) {

            return back()->with(['error' => ['Something went wrong! Please try again']]);
        }
        return redirect()->route('user.add.baby.pet.index')->with(['success' => ['Profession updated successfully']]);
    }
    function delete(Request $request)
    {
        $add_baby_pet_id = $request->target;
        $add_baby_pet_id = AddBabyPat::findOrFail($add_baby_pet_id);
        try {
            $add_baby_pet_id->delete();
        } catch (Exception $e) {
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }
        return redirect()->route('user.add.baby.pet.index')->with(['success' => ['Deleted Successfully']]);
    }
}
