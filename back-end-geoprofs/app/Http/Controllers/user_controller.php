<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;//depends on model
use Illuminate\Support\Facades\Cache;

class user_controller extends Controller
{
    public function getUserData(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'access_token' => 'required|string',
            'cache_id' => 'required|string',
            'target_user_id' => 'required|integer'
        ]);

        $accessToken = Cache::get('user_token:' . $request->user_id . "_" . $request->cache_id);

        if($accessToken != $request->access_token){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $targetUser = User::where('id', $request->target_user_id)->first();

        //TODO add check if data may be accessed by user

        return response()->json([
            'user_data' => $targetUser,
        ]);
    }
}
