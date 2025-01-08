<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
            return response()->json(['message' => 'Invalid credentials'], 401);//also stops code from continuing 
        }

        return response()->json([
            'message' => "succes"
        ]);  
    }
}