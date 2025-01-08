<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DepartmentEmployee;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class department_controller extends Controller
{
    public function getUsers(Request $request){
        Log::info('getUsers endpoint hit.');

        $request->validate([
            'idUser' => 'required|integer',
            'userToken' => 'required|string',
            'cacheId' => 'required|string',
            'idDepartment' => 'required|integer'
        ]);

        $userToken = Cache::get('user_token:' . $request->idUser . "_" . $request->cacheId);

        if($userToken != $request->userToken){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = User::where('id', $request->idUser)->first();
        $departmentEmployee = DepartmentEmployee::where('user_id', $request->idUser)->first();

        if(!($user->role == 'CEO' || $departmentEmployee->department_id == $request->idDepartment || ($user->role == 'section-Manager' && true /* to do: check if section manger is managing has target department */))){
            return response()->json(['message' => 'You do not have the necessary permissions to access this data.'], 403);
        }

        $departmentEmployees = DepartmentEmployee::where('department_id', $request->idDepartment)->get();

        $userIds = $departmentEmployees->pluck('user_id');

        return response()->json([
            'user_ids' => $userIds
        ]);  
    }
}