<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequests;
use App\Models\User;//depends on model
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\LeaveRequestsCategories;

use \DateTime;

class LeaveRequestsController extends Controller
{
    public function seeCurrentLeaveSaldo(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'access_token' => 'required|string',
            'cache_id' => 'required|string',
            'target_user_id' => 'required|integer'
        ]);

        $accessToken = Cache::get('user_token:' . $request->user_id . "_" . $request->cache_id);

        if($accessToken != $request->access_token){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $targetUser = User::where('id', $request->target_user_id)->first();

        //TODO add check if data may be accessed by user

        return response()->json([
            'leave_days' => $targetUser ->leave_days,
        ]);
    }

    public function createLeaveRequest(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'access_token' => 'required|string',
            'cache_id' => 'required|string',

            'description' => 'required|string',
            'category' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_paid' => 'required|boolean',
        ]);

        $accessToken = Cache::get('user_token:' . $request->user_id . "_" . $request->cache_id);

        if($accessToken != $request->access_token){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $leaveRequest = new LeaveRequests();
        $leaveRequest->description = $request->input('description');
        $leaveRequest->leave_requests_category_id = $request->input('category');

        $startDate = new DateTime( $request->input('start_date'));
        $endDate = new DateTime( $request->input('end_date'));

        $leaveRequest->leave_days = ($startDate->diff($endDate)->days)+1;
        $leaveRequest->start_date = $request->input('start_date');
        $leaveRequest->end_date = $request->input('end_date');
        $leaveRequest->is_paid = $request->input('is_paid');
        $leaveRequest->employee_id = $request->user_id;

        $leaveRequest->leave_status = 0;

        $leaveRequest->save();

        return response()->json(['message' => 'Leave request submitted successfully!']);
    }

    public function approveOrDeclineLeaveRequest(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'access_token' => 'required|string',
            'cache_id' => 'required|string',

            'leave_request_id' => 'required|integer',
            'value' => 'required|integer|in:1,2',//1 decline 2 approve
        ]);

        $accessToken = Cache::get('user_token:' . $request->user_id . "_" . $request->cache_id);

        if($accessToken != $request->access_token){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $leaveRequest = LeaveRequests::where('id', $request->leave_request_id)->first();

        //TODO add check if data may be declined by user

        if (!$leaveRequest) {
            return response()->json(['error' => 'Leave request not found'], 404);
        }

        if($leaveRequest->leave_status != 0){
            return response()->json([
                'error' => 'This request can no longer be approved or declined as it is no longer pending.'
            ], 422);
        }

        if($request->value == 2){
            $targetUser = User::where('id', $leaveRequest->employee_id)->first();
            $targetUser->update(['leave_days' => ($targetUser->leave_days - $leaveRequest->leave_days)]);
        }

        $leaveRequest->update(['leave_status' => $request->value]);

        return response()->json([
            'message' => 'Leave request successfully approved or declined'
        ]);
    }

    public function getLeaveRequests(Request $request){
        $request->validate([
            'user_id' => 'required|integer',
            'access_token' => 'required|string',
            'cache_id' => 'required|string',
        ]);

        $accessToken = Cache::get('user_token:' . $request->user_id . "_" . $request->cache_id);

        if($accessToken != $request->access_token){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // $targetUser = User::where('id', $request->target_user_id)->first();

        $leaveRequests = LeaveRequests::all();//TODO make it get all leave requests is permitted to see and if even allowed to see one

        foreach ($leaveRequests as $leaveRequest) {
            $leaveRequest->user_name = User::where('id', $leaveRequest->employee_id)->first()->name;
        }

        return response()->json([
            'leave_requests' => $leaveRequests,
        ]);
    }

    public function getLeaveRequestData(Request $request){

        Log::info('hit getLeaveRequestData');
        Log::info($request);

        $request->validate([
            'user_id' => 'required|integer',
            'access_token' => 'required|string',
            'cache_id' => 'required|string',

            'leave_request_id' => 'required|integer',
        ]);

        $accessToken = Cache::get('user_token:' . $request->user_id . "_" . $request->cache_id);

        if($accessToken != $request->access_token){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        //TODO check if user is allowed to see data
        
        $leaveRequest = LeaveRequests::where('id', $request->leave_request_id)->first();

        $leaveRequest->user_name = User::where('id', $leaveRequest->employee_id)->first()->name;
        
        return response()->json([
            'leave_request' => $leaveRequest,
        ]);
    }

}