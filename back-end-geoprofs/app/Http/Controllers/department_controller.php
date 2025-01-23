<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DepartmentEmployee;
use App\Models\DepartmentSection;
use App\Models\Section;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class department_controller extends Controller
{
    public function getUsers(Request $request){

        Log::info('getUsers from department controller');

        $request->validate([
            'user_id' => 'required|integer',
            'access_token' => 'required|string',
            'cache_id' => 'required|string',
            'id_department' => 'required|integer'
        ]);

        Log::info('went past request');     

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

    // public function getManger(Request $request){
    //     $request->validate([
    //         'idUser' => 'required|integer',
    //         'userToken' => 'required|string',
    //         'cacheId' => 'required|string',
    //         'idDepartment' => 'required|integer'
    //     ]);

    //     Log::info('getManger from department controller');

    //     $userToken = Cache::get('user_token:' . $request->idUser . "_" . $request->cacheId);

    //     if($userToken != $request->userToken){
    //         return response()->json(['message' => 'Invalid credentials'], 401);
    //     }

    //     $user = User::where('id', $request->idUser)->first();
    //     $departmentEmployee = DepartmentEmployee::where('user_id', $request->idUser)->first();

    //     if(!(
    //         $user->role == 'CEO' ||
    //         $departmentEmployee?->department_id == $request->idDepartment ||
    //         ($user->role == 'section-Manager' && $this->sectionMangerCheck($request->idUser , $request->idDepartment))
    //     ))
    //     {
    //         return response()->json(['message' => 'You do not have the necessary permissions to access this data.'], 403);
    //     }

    //     $department = Department::where('id', $request->idDepartment)->first();

    //     $mangerId = $department->manager_role_id;

    //     return response()->json([
    //         'manger_id' => $mangerId
    //     ]);  
    // }

    // private function sectionMangerCheck($userId , $departmentId)
    // {
    //     Log::info('sectionMangerCheck from department controller');
    //     $section = Section::where('manager_role_id' , $userId)->first();
    //     Log::info('id of section is:' . $section?->id);
    //     $departmentSection = DepartmentSection::where('department_id' , $departmentId)->first();
    //     if($departmentSection?->section_id == $section?->id){
    //         return true;
    //     }
    //     return false;
    // }
}