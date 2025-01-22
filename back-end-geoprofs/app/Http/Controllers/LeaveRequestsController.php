<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequests;

class LeaveRequestsController extends Controller
{
    //



    public function requestLeaveStatus(Request $request, $leaveRequestId)
    {
        // Mock data for leave request leave status
        //TODO Here auth check


        //Here a check whether the user is logged in or not
        //    if(!$user ) {

        //     return response()->json(['error' => 'Unauthorized'], 401);
        //    }



        $leaveRequest = LeaveRequests::where('id', $leaveRequestId)
            ->where('user_id', $user->id) //Add here the user value
            ->first(['id', 'leave_status']);

        //Check whether the leave request is found or not
        if (!$leaveRequest) {
            return response()->json(['error' => 'Leave request not found or not accessible'], 404);
        }


        //Too make the output more readable
        $statusMapping = [
            0 => 'Pending',
            1 => 'Approved',
            2 => 'Rejected',
        ];

        return response()->json([
            'leave_request_id' => $leaveRequest->id,
            'leave_status' => $statusMapping,
        ]);
    }


}
