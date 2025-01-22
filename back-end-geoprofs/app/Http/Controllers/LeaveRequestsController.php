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
        $mockUser = [
            'id' => 1,
            'name' => 'John Doe',
            'leave_days' => 1,
        ];

        // Check if mock user exists (simulating authentication)
        if (!$mockUser) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Return mock leave saldo data
        return response()->json([
            'user_id' => $mockUser['id'],
            'name' => $mockUser['name'],
            'leave_days' => $mockUser['leave_days'],
        ]);
    }

}
