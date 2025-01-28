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
        Log::info('hit createLeaveRequest');

        $request->validate([
            'user_id' => 'required|integer',
            'access_token' => 'required|string',
            'cache_id' => 'required|string',

            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|integer',
            // 'category' => 'required|exists:leave_requests_categories,id', // Ensure the category exists
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_paid' => 'required|boolean',
        ]);

        Log::info('got past validation');

        $accessToken = Cache::get('user_token:' . $request->user_id . "_" . $request->cache_id);

        if($accessToken != $request->access_token){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        
        Log::info('got past login check');

        $leaveRequest = new LeaveRequests();
        $leaveRequest->title = $request->input('title');
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

    public function declineSectionManagerLeaveRequest($id)
    {

        //TODO Retrieve  the user  

        // if ($user != "ceo") {

        //     return response()->json(['error' => 'You are not authorized to decline this leave request'], 403);
        // }

        // Find the specific leave request
        $leaveRequest = LeaveRequests::findOrFail($id);

        if (!$leaveRequest) {
            return response()->json(['error' => 'Leave request not found'], 404);
        }

        //get the employee associated with the leave request
        $employee = $leaveRequest->employee;

        // TODO Add here the logic to check if the user is has role CEO, and the  employee section manager
        // if (!$currentUser->isCEO() || $employee->role !== 'section_manager') {
        //     return response()->json([
        //         'error' => 'You are not authorized to decline this leave request'
        //     ], 403);     
        // }

        //Update the leave request status
        $leaveRequest->update(['leave_status' => 2]);


        return response()->json([
            'message' => 'Leave request succesfully declined'
        ], 403);

    }
}