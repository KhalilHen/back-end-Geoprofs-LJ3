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
        $mockLeaveRequests = [
            ['id' => 1, 'user_id' => 101, 'leave_status' => 'Approved'],
            ['id' => 2, 'user_id' => 102, 'leave_status' => 'Pending'],
            ['id' => 3, 'user_id' => 101, 'leave_status' => 'Rejected'],
        ];

        $mockUser = ['id' => 101, 'name' => 'John Doe']; // Simulating a logged-in user

        $leaveRequest = collect($mockLeaveRequests)->first(function ($request) use ($leaveRequestId, $mockUser) {
            return $request['id'] === (int) $leaveRequestId && $request['user_id'] === $mockUser['id'];
        });

        if (!$leaveRequest) {
            return response()->json(['error' => 'Leave request not found or not accessible'], 404);
        }

        return response()->json([
            'leave_request_id' => $leaveRequest['id'],
            'leave_status' => $leaveRequest['leave_status'],
        ]);
    }


}
