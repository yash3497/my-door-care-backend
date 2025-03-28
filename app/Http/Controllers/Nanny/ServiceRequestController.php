<?php

namespace App\Http\Controllers\Nanny;

use Exception;
use App\Models\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\UserNotification;
use App\Models\Admin\BasicSettings;
use App\Constants\NotificationConst;
use App\Http\Controllers\Controller;
use App\Notifications\User\ServiceRequestEmail;
use App\Notifications\User\ServiceTaskComplate;
use App\Notifications\User\ServiceRequestRejectEmail;
use Illuminate\Support\Facades\DB;

class ServiceRequestController extends Controller
{
    function index()
    {
        $nanny_id = auth()->user()->id;
        $user_requests = UserRequest::with('user')->where('nanny_id', $nanny_id)->latest()->get();
        return view('nanny.sections.service-request.index', compact('user_requests'));
    }

    function approved($id)
    {
        $service_request = UserRequest::with('user', 'nanny')->findOrFail($id);
        $user = $service_request->user;
        $nanny = $service_request->nanny;


        $basic_setting = BasicSettings::first();
        try{
            if ($basic_setting->email_notification == 1) {
                $user->notify(new ServiceRequestEmail($nanny));
            }
        }catch(Exception $e){
            //handle error
        }


        try {
            DB::beginTransaction();
            $service_request->update(['status' => 1]);
            //notification
            $notification_content = [
                'title'         => "Request Accepted",
                'message'       => $nanny->fullname . " has accepted your request",
                'time'          => Carbon::now()->diffForHumans(),
                'image'         => files_asset_path('profile-default'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::NANNY_SERVICE_ACCEPTED,
                'user_id'  =>  $user->id,
                'message'   => $notification_content,
            ]);
            DB::commit();
        } catch (Exception $e) {

            DB::rollBack();
            return back()->with(['error' => ['Something went wrong, Please try again']]);
        }
        return back()->with(['success' => ['You have accepted the request']]);
    }
    function rejected($id)
    {
        $service_request = UserRequest::with('user', 'nanny')->findOrFail($id);
        $user = $service_request->user;
        $nanny = $service_request->nanny;

        $basic_setting = BasicSettings::first();
        if ($basic_setting->email_notification == 1) {
            $user->notify(new ServiceRequestRejectEmail($nanny));
        }
        try {
            DB::beginTransaction();
            $service_request->update(['status' => 2]);
            //notification
            $notification_content = [
                'title'         => "Request Rejected",
                'message'       => $nanny->fullname . " has rejected your request",
                'time'          => Carbon::now()->diffForHumans(),
                'image'         => files_asset_path('profile-default'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::NANNY_SERVICE_REJECTED,
                'user_id'  =>  $user->id,
                'message'   => $notification_content,
            ]);
            DB::commit();
        } catch (Exception $e) {

            DB::rollBack();
            return back()->with(['error' => ['Something went wrong, Please try again']]);
        }
        return back()->with(['success' => ['You have rejected the request']]);
    }
    function taskComplate($id)
    {
        $service_request = UserRequest::with('user', 'nanny')->findOrFail($id);
        $user = $service_request->user;
        $nanny = $service_request->nanny;
        $basic_setting = BasicSettings::first();
        try{
            if ($basic_setting->email_notification == 1) {
                $user->notify(new ServiceTaskComplate($service_request));
            }
        }catch(Exception $e){
            //handle error
        }

        try {
            DB::beginTransaction();
            $service_request->update(['status' => 4]);
            //notification
            $notification_content = [
                'title'         => "Task completed",
                'message'       => $nanny->fullname . " task completed",
                'time'          => Carbon::now()->diffForHumans(),
                'image'         => files_asset_path('profile-default'),
            ];

            UserNotification::create([
                'type'      => NotificationConst::NANNY_TASK_completed,
                'user_id'  =>  $user->id,
                'message'   => $notification_content,
            ]);
            DB::commit();
        } catch (Exception $e) {

            DB::rollBack();
            return back()->with(['error' => ['Something went wrong, Please try again']]);
        }
        return back()->with(['success' => ['You have completed the task']]);
    }
    public function watchStatus($id)
    {
        $user_request = UserRequest::findOrFail($id);
        if ($user_request->seen_status == 'unseen') {
            $user_request->seen_status = 'seen';
        }
        $user_request->update();
        $unseen_user_request_count = UserRequest::where('seen_status', 'unseen')->count();
        return response()->json($unseen_user_request_count);
    }
}
