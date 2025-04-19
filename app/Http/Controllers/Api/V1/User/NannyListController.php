<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Models\Nanny;
use App\Models\Review;
use App\Models\AddBabyPat;
use App\Models\UserRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\ServiceArea;
use App\Http\Controllers\Controller;
use App\Models\Admin\TransactionSetting;
use App\Http\Helpers\Api\Helpers as ApiResponse;

use Illuminate\Support\Facades\Log;

class NannyListController extends Controller
{
    public function index(Request $request)
{
    try {
        Log::info('API: Nanny index called.');

        $user_city = Str::slug(auth()->user()->address->city);
        Log::info('User City: ' . $user_city);

        $service_area = ServiceArea::get();
        Log::info('Fetched Service Areas', ['count' => $service_area->count()]);

        // Initialize filters
        $area = $request->area ?? '';
        $profession_type = $request->profession_type ?? '';
        $work_experience = $request->work_experience ?? '';
        $work_capability = $request->work_capability ?? '';
        $charge = $request->charge ?? '';

        Log::info('Request Filters', compact('area', 'profession_type', 'work_experience', 'work_capability', 'charge'));

        $query = Nanny::where('kyc_verified', 1)
            ->with('review', 'userRequests', 'nannyProfession')
            ->whereHas('nannyProfession', function ($q) use ($user_city, $area, $profession_type, $work_experience, $work_capability, $charge) {
                Log::info('Inside whereHas - Applying Filters');

                $q->when(!empty($area), function ($q) use ($area) {
                    $q->where('service_area', $area);
                    Log::info('Filter applied: area = ' . $area);
                }, function ($q) use ($user_city) {
                    $q->where('service_area', $user_city);
                    Log::info('Default area used: ' . $user_city);
                });

                if (!empty($profession_type)) {
                    $q->where('profession_type', $profession_type);
                    Log::info('Filter applied: profession_type = ' . $profession_type);
                }
                if (!empty($work_experience)) {
                    $q->where('work_experience', $work_experience);
                    Log::info('Filter applied: work_experience = ' . $work_experience);
                }
                if (!empty($work_capability)) {
                    $q->where('work_capability', $work_capability);
                    Log::info('Filter applied: work_capability = ' . $work_capability);
                }
                if (!empty($charge)) {
                    $q->where('charge', $charge);
                    Log::info('Filter applied: charge = ' . $charge);
                }
            })
            ->orderBy('id', 'DESC');

        $nannies = $query->limit(6)->get();

        Log::info('Fetched Nannies Count: ' . $nannies->count());

        $profession_type = [
            ['value' => 1, 'label' => 'Baby Sitter'],
            ['value' => 2, 'label' => 'Pet Sitter']
        ];

        $work_experience = [
            'o - 6 Month',
            '6 Month - 1year',
            '1 year - 1.5 Year',
            '1.5 year - 2 Year',
            '2 year - 3 Year',
            '3 year - 4 Year',
            '5 year - 6 Year',
            '6+ year',
        ];

        $work_capability = [
            '12 - 24 Hours', '2 Day', '3 Day', '5 Day', '1 Week', '2 Week', '1 Month',
        ];

        $charge = ['Hourly', 'Daily', 'Weekly', 'Monthly'];

        $data = [
            'base_url' => url(''),
            'default_image' => "public/backend/images/default/profile-default.webp",
            "image_path" => "public/frontend/nanny",
            'nannies' => $nannies,
            'area' => $service_area,
            'profession_type' => $profession_type,
            'work_experience' => $work_experience,
            'work_capability' => $work_capability,
            'charge' => $charge
        ];

        $message = ['success' => [__('All nanny list')]];
        return ApiResponse::success($message, $data);
    } catch (\Exception $e) {
        Log::error('Error in index(): ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return ApiResponse::error(['error' => ['Something went wrong! Please try again later.']]);
    }
}
    function nannyDetails($id)
    {
        $nanny = Nanny::with('review', 'userRequests', 'nannyProfession')->findOrFail($id);
        $user_id = auth()->user()->id;

        $total_nanny_service = UserRequest::where('nanny_id', $nanny->id)->whereIn('status', [1, 4, 5, 6])->count();
        $total_nanny_task_complate = UserRequest::where('nanny_id', $nanny->id)->whereIn('status', [4, 5, 6])->count();
        $reviews = Review::where('nanny_id', $nanny->id)->get();
        $my_baby_pet_list = AddBabyPat::where('user_id', $user_id)->get();

        $data = [
            'base_url' => url('/'),
            'image_path' => 'public/frontend/nanny',
            'default' => 'public/backend/images/default/default.webp',
            'nanny' => $nanny,
            'total_nanny_service' => $total_nanny_service,
            'total_nanny_task_complate' => $total_nanny_task_complate,
            'reviews' => $reviews,
            'my_baby_pet_list' => $my_baby_pet_list,
        ];
        $message = ['success' => [__('Nanny details')]];

        return ApiResponse::success($message, $data);
    }

    function serviceRequest($id)
    {
        $nanny = Nanny::findOrFail($id);
        $user_id = auth()->user()->id;
        $nanny_profession_type = $nanny->nannyProfession->profession_type;
        $myBabyPets = AddBabyPat::where('user_id', $user_id)->where('profession_type', $nanny_profession_type)->orderBy('id', 'DESC')->limit(2)->get();

        $service_charge =  TransactionSetting::without('admin')->first()->toArray();
        return view('user.sections.nanny-list.service-request', compact('nanny', 'myBabyPets', 'service_charge'));
    }
}
