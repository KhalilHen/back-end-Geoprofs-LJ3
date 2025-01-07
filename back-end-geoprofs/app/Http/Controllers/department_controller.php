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

        $user = User::where('id', $request->idUser)->first();

        return response()->json([
            'role' => $user->role   
        ]);  
    }
}
