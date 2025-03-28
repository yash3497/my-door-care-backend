<?php

namespace App\Http\Controllers\Api\V1\Nanny;

use Exception;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use App\Models\Admin\BasicSettings;
use App\Http\Controllers\Controller;
use App\Notifications\User\ServiceRequestEmail;
use App\Notifications\User\ServiceTaskComplate;
use App\Http\Helpers\Api\Helpers as ApiResponse;
use App\Notifications\User\ServiceRequestRejectEmail;

class ServiceRequestController extends Controller
{
    function index()
    {
        $nanny_id = auth()->user()->id;
        $user_requests = UserRequest::with('user')->where('nanny_id', $nanny_id)->get();
        $data = [
            'user_request' => $user_requests
        ];
        $message = ['success' => [__('User service request')]];
        return ApiResponse::success($message, $data);
    }

    function serviceRequestUpdate(Request $request, $id)
    {
        $service_request = UserRequest::with('user', 'nanny')->findOrFail($id);
        $user = $service_request->user;
        $nanny = $service_request->nanny;

        $basic_setting = BasicSettings::first();
        try{
            if ($basic_setting->email_notification == 1) {
                if ($service_request->status == 1) {
                    $user->notify(new ServiceRequestEmail($nanny));
                } elseif ($service_request->status == 2) {
                    $user->notify(new ServiceRequestRejectEmail($nanny));
                } elseif ($service_request->status == 4) {
                    $user->notify(new ServiceTaskComplate($service_request));
                }
            }
        }catch(Exception $e){
            //handle error
        }

        try {
            $service_request->update(['status' => $request->status]);
        } catch (Exception $e) {

            $error = ['error' => [__('Something went wrong, Please try again')]];
            return ApiResponse::error($error);
        }
        if ($request->status == 1) {
            $message = ['success' => [__('You have accepted the request')]];
        } elseif ($request->status == 2) {
            $message = ['success' => [__('You have rejected the request')]];
        } elseif ($request->status == 4) {
            $message = ['success' => [__('You have task complete')]];
        } elseif ($request->status == 5) {
            $message = ['success' => [__('You have payment complete')]];
        } elseif (6 == $request->status) {
            $message = ['success' => [__('You have review complete')]];
        }
        return ApiResponse::onlysuccess($message);
    }
}
