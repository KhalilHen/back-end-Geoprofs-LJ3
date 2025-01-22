<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequests;

class LeaveRequestsController extends Controller
{
    //












    public function seeCurrentLeaveSaldo()
    {
        // Simulate the authenticated user
        // $mockUser = [
        //     'id' => 1,
        //     'name' => 'John Doe',
        //     'leave_days' => 1,
        // ];
        //TODO add here the auth 

        //* Check here  if the user is authenticated
        // if (!$user) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        //* Here retrieve the value of the leave days column based on the connected user
        return response()->json([
            'user_id' => $userId['id'], //use the auth value here
            'name' => $mockUser['name'],
            'leave_days' => $mockUser['leave_days'],
        ]);
    }

}
