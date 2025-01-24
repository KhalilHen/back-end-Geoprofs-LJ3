<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequests;
use App\Models\User;
class LeaveRequestsController extends Controller
{






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