<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequests;

class LeaveRequestsController extends Controller
{
    //


















    public function past30Days(Request $request)
    {

        // TODO add auth check to check if users is  admin


        try {
            $leaveRequestResponse = LeaveRequests::where('leave_status', 'approved')
            ->where('updated_at', '>=', value: now()->subDays(30))
            ->get();

                if($leaveRequestResponse->isEmpty() || $leaveRequestResponse == null) {

            return response()->json(['message' => 'No leave requests approved'], 404);


                } 
                
                return response()->json($leaveRequestResponse);

        }
        catch (\Exception $e)  {

                return response()->json(['message' => 'Error fetching  : ' . $e->getMessage()], 500);
        }
        
        

    }


}
