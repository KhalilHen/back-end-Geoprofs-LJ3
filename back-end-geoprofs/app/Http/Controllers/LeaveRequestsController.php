<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequests;

class LeaveRequestsController extends Controller
{
    //
    public function displayLeaveRequest()
    {

        $leaveRequestsResponse = LeaveRequests::all();

        //TODO Change later  that it converts to the leave request cards
        if ($leaveRequestsResponse->isEmpty()) {
            return response()->json(['message' => 'No leave requests found'], 404);
        }

        return response()->json($leaveRequestsResponse);
    }
}
