<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequestsCategories;
use App\Models\User;
class leave_request_category extends Controller
{
    //

    public function createLeaveCategory(Request $request)
    {
       //TODO Add here the authentication check
        // if (auth()->user()->role != 'admin') {
        //     return response()->json(['message' => 'Not accessible'], 403);
        // }

        // $request->validate([
        //     'name' => 'required',
        // ]);

        // Create a new Leave instance
        $leaveCategory = new LeaveRequestsCategories();

        // Fill the Leave model with the validated data
        $leaveCategory->title = $request->input('title');

        // Save the Leave to the database
        $leaveCategory->save();

        // Redirect or return a response (e.g., success message)
        return response()->json(['message' => 'Leave request category submitted successfully!']);

    }
    public function displayLeaveCategory()
    {
        // Fetch all leave categories
        $leaveCategory = LeaveRequestsCategories::all('title');

        // Return the categories as JSON data
        return response()->json($leaveCategory);
    }


}
