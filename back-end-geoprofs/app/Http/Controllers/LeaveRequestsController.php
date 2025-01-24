<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequests;


use App\Models\LeaveRequestsCategories;
class LeaveRequestsController extends Controller
{
    //




    public function createLeaveRequest(Request $request)
    {

        //TODO  Add auth logic
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|exists:leave_requests_categories,id', // Ensure the category exists
            'leave_days' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_paid' => 'required|boolean',
            // 'employee_id'   

        ]);



        $leaveRequest = new LeaveRequests();
        $leaveRequest->title = $request->input('title');
        $leaveRequest->description = $request->input('description');
        $leaveRequest->leave_requests_category_id = $request->input('category');

        $leaveRequest->leave_hours = $request->input('leave_days'); //TODO Change this later into leave_days
        $leaveRequest->start_date = $request->input('start_date');
        $leaveRequest->end_date = $request->input('end_date');
        $leaveRequest->is_paid = $request->input('is_paid');
        $leaveRequest->employee_id = 3; //TODO Change this later into a employee id

        $leaveRequest->leave_status = 0;
        // Save to the database
        $leaveRequest->save();

        // Return success response
        return response()->json(['message' => 'Leave request submitted successfully!']);
    }


}
