<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequestsCategories;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class leave_request_category extends Controller
{
    //

    public function createLeaveCategory(Request $request)
    {




        // Validate the request input
        $request->validate([
            'idUser' => 'required|integer',
            'userToken' => 'required|string',
            'cacheId' => 'required|string',
            'title' => 'required|string',
        ]);




        // Retrieve the cached user token
        $userToken = Cache::get('user_token:' . $request->idUser . "_" . $request->cacheId);
dd($userToken);
        // Check if the token is valid
        if ($userToken !== $request->userToken) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Retrieve the user and check their role
        $user = User::find($request->idUser);

        if (!$user || $user->role !== 'CEO') {
            return response()->json(['message' => 'You do not have the necessary permissions to perform this action.'], 403);
        }

        Log::info('leave_request_category hit');

        // Create the new leave request category
        $leaveCategory = new LeaveRequestsCategories();
        $leaveCategory->title = $request->input('title');
        $leaveCategory->save();

        // Return success response
        return response()->json(['message' => 'Leave request category created successfully!']);
    }
    public function displayLeaveCategory()
    {
        // Fetch all leave categories
        $leaveCategory = LeaveRequestsCategories::all('title');

        // Return the categories as JSON data
        return response()->json($leaveCategory);
    }


}
