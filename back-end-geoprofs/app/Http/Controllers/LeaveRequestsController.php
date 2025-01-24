<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequests;

class LeaveRequestsController extends Controller
{


    private $mockUsers = [];
    private $mockLeaveRequests = [];

    public function __construct()
    {
        $this->mockUsers = [
            1 => [
                'id' => 1,
                'name' => 'Sarah CEO',
                'role' => 'CEO',
                'department_id' => null,
                'section_id' => null
            ],
            2 => [
                'id' => 2,
                'name' => 'Mike Johnson',
                'role' => 'section_manager',
                'department_id' => 2,
                'section_id' => 2
            ],
            3 => [
                'id' => 3,
                'name' => 'Jane Doe',
                'role' => 'employee',
                'department_id' => 3,
                'section_id' => 3
            ]
        ];

        $this->mockLeaveRequests = [
            1 => [
                'id' => 1,
                'title' => 'Leave Request 1',
                'employee_id' => 2,
                'leave_status' => 'pending',
                'department_id' => 2,
                'section_id' => 2
            ],
            2 => [
                'id' => 2,
                'title' => 'Leave Request 2',
                'employee_id' => 3,
                'leave_status' => 'pending',
                'department_id' => 3,
                'section_id' => 3
            ]
        ];
    }

    public function index()
    {
        $currentUser = $this->mockUsers[1]; //1 = CEO  2 = section manager 3= employee
        $filteredRequests = array_filter($this->mockLeaveRequests, function ($request) use ($currentUser) {
            // Retrieve the role of the employee who made the leave request
            $employee = $this->mockUsers[$request['employee_id']] ?? null;

            if (!$employee) {
                return false;
            }

            // Filter leave requests where:
            // - The current user is a CEO
            // - The employee role is 'section_manager'
            return $currentUser['role'] === 'CEO' && $employee['role'] === 'section_manager';
        });

        // Pass filtered requests to the view
        return view('leave_request', [
            'leaveRequests' => $filteredRequests,
            'currentUser' => $currentUser
        ]);
    }

    public function declineLeaveRequest($id)
    {
        $currentUser = $this->mockUsers[1]; // 1 = CEO 2 =  section-manager 3= employee

        // Find the specific leave request
        $leaveRequest = $this->mockLeaveRequests[$id] ?? null;

        if (!$leaveRequest) {
            return response()->json(['error' => 'Leave request not found'], 404);
        }

        // Retrieve the employee who made the leave request
        $employee = $this->mockUsers[$leaveRequest['employee_id']] ?? null;

        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        // Check if the current user is authorized to decline the leave request
        if ($currentUser['role'] === 'CEO' && $employee['role'] === 'section_manager') //TODO Adjust the role names if it's full uppercase letters.
        {
            // Simulate declining the leave request
            $this->mockLeaveRequests[$id]['leave_status'] = 'declined';

            // Delete simulation
            unset($this->mockLeaveRequests[$id]);

            return response()->json([
                'message' => "Leave request declined and removed successfully",
                'leave_request_id' => $id,
                'current_user_role' => $currentUser['role']
            ]);
        }

        return response()->json([
            'error' => 'You are not authorized to decline this leave request'
        ], 403);
    }


}