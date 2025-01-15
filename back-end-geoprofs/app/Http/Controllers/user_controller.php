<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;//depends on model
use Illuminate\Support\Facades\Log;
use App\Models\DepartmentEmployee;
use App\Models\DepartmentSection;
use App\Models\Section;


class user_controller extends Controller
{
    public function getUserData(Request $request){

        $request->validate([
            'idUser' => 'required|integer',
            'userToken' => 'required|string',
            'cacheId' => 'required|string',
            'idTargetUser' => 'required|integer'
        ]);


        $userToken = Cache::get('user_token:' . $request->idUser . "_" . $request->cacheId);

        if($userToken != $request->userToken){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = User::where('id', $request->idUser)->first();

        if(!(
            true //TODO add check if user has right to data
        ))
        {
            return response()->json(['message' => 'You do not have the necessary permissions to access this data.'], 403);
        }

        $targetUser = User::where('id', $request->idTargetUser)->first();

        return response()->json(['user' => 'targetUser']);
    }
}
