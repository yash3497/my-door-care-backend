<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Nanny;
use App\Models\Review;
use App\Models\AddBabyPat;
use App\Models\UserRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\ServiceArea;
use App\Http\Controllers\Controller;
use App\Models\Admin\TransactionSetting;

class NannyListController extends Controller
{
    function index(Request $request)
    {
        $user_city = Str::slug(auth()->user()->address->city);
        $service_area = ServiceArea::get();

        $area = '';
        $profession_type = '';
        $work_experience = '';
        $work_capability = '';
        $charge = '';

        if (isset($request->area) && !empty($request->area)) {
            $area = $request->area;
        }
        if (isset($request->profession_type) && !empty($request->profession_type)) {
            $profession_type = $request->profession_type;
        }
        if (isset($request->work_experience) && !empty($request->work_experience)) {
            $work_experience = $request->work_experience;
        }
        if (isset($request->work_capability) && !empty($request->work_capability)) {
            $work_capability = $request->work_capability;
        }
        if (isset($request->charge) && !empty($request->charge)) {
            $charge = $request->charge;
        }

        $query = Nanny::where('kyc_verified', 1)->with('review', 'userRequests')->whereHas('nannyProfession', function ($q) use ($user_city, $area, $profession_type, $work_experience, $work_capability, $charge) {

            if (!empty($area)) {
                $q->where('service_area', $area);
            } else {
                $q->where('service_area', $user_city);
            }
            if (!empty($profession_type)) {
                $q->where('profession_type', $profession_type);
            }
            if (!empty($work_experience)) {
                $q->where('work_experience', $work_experience);
            }
            if (!empty($work_expework_capabilityrience)) {
                $q->where('work_capability', $work_capability);
            }
            if (!empty($charge)) {
                $q->where('charge', $charge);
            }
        })->orderBy('id', 'DESC');



        $nannies = $query->limit(6)->get();

        $service_areas = ServiceArea::get();
        return view('user.sections.nanny-list.index', compact('nannies', 'service_areas'));
    }

    function nannyDetails($id)
    {
        $nanny = Nanny::with('review', 'userRequests')->findOrFail($id);

        $total_nanny_service = UserRequest::where('nanny_id', $nanny->id)->whereIn('status', [1, 4, 5, 6])->count();
        $total_nanny_task_complate = UserRequest::where('nanny_id', $nanny->id)->whereIn('status', [4, 5, 6])->count();
        $reviews = Review::where('nanny_id', $nanny->id)->get();
        
        return view('user.sections.nanny-list.details', compact('nanny', 'total_nanny_service', 'total_nanny_task_complate', 'reviews'));
    }
    function serviceRequest($id)
    {
        $nanny = Nanny::findOrFail($id);
        $user_id = auth()->user()->id;
        $nanny_profession_type = $nanny->nannyProfession->profession_type;
        $myBabyPets = AddBabyPat::where('user_id', $user_id)->where('profession_type', $nanny_profession_type)->orderBy('id', 'DESC')->get();
        $service_charge =  TransactionSetting::without('admin')->first()->toArray();
        return view('user.sections.nanny-list.service-request', compact('nanny', 'myBabyPets', 'service_charge'));
    }
}
