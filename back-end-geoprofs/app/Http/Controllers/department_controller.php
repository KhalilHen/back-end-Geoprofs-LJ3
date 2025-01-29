<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DepartmentEmployee;
use App\Models\MangerSection;
use App\Models\Section;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class department_controller extends Controller
{
    public function getUsers(Request $request){
        $request->validate([
            'user_id' => 'required|integer',
            'access_token' => 'required|string',
            'cache_id' => 'required|string',
            'id_department' => 'required|integer'
        ]);    

        $accessToken = Cache::get('user_token:' . $request->user_id . "_" . $request->cache_id);

        if($accessToken != $request->access_token){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = User::where('id', $request->user_id)->first();

        if(!(
            $user->role == 'CEO' ||
            $user?->department_id == $request->id_department ||
            ($user->role == 'section-Manager' && $this->sectionMangerCheck($request->user_id , $request->id_department))
        ))
        {
            return response()->json(['message' => 'You do not have the necessary permissions to access this data.'], 403);
        }

        $userIds = User::where('department_id', $request->id_department)->get()->pluck('id');;

        return response()->json([
            'user_ids' => $userIds
        ]);  
    }

    public function getManger(Request $request){
        $request->validate([
            'user_id' => 'required|integer',
            'access_token' => 'required|string',
            'cache_id' => 'required|string',
            'id_department' => 'required|integer'
        ]);    

        $accessToken = Cache::get('user_token:' . $request->user_id . "_" . $request->cache_id);

        if($accessToken != $request->access_token){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = User::where('id', $request->user_id)->first();

        if(!(
            $user->role == 'CEO' ||
            $user?->department_id == $request->id_department ||
            ($user->role == 'section-Manager' && $this->sectionMangerCheck($request->user_id , $request->id_department))
        ))
        {
            return response()->json(['message' => 'You do not have the necessary permissions to access this data.'], 403);
        }

        $userIds = User::where('department_id', $request->id_department)->where('role', 'Manager')->get()->pluck('id');

        return response()->json([
            'user_ids' => $userIds
        ]); 
    }

    private function sectionMangerCheck($userId , $departmentId)
    {
        $mangerSection = MangerSection::where('manager_role_id_user' , $userId)->first();
        $department = Department::where('id' , $departmentId)->first();
        if($mangerSection?->section_id == $department?->section_id){
            return true;
        }
        return false;
    }
}