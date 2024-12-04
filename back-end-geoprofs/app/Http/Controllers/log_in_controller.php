<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;//depends on model
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class log_in_controller extends Controller
{
    public function logIn(Request $request)
    {
        $validTokenTime = 120; //in minutes

        $request->validate([
            'emailOrId' => 'required|string', //can be id or email
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->emailOrId)->first();//depends on model

        if(is_null($user)){
            $user = User::where('id', $request->emailOrId)->first();//depends on model
        }

        // log in attempts limiter need to be added

        if(is_null($user) || !Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'Invalid credentials'], 401);//also stops code from continuing 
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        
        $uniqid = Str::random(16);
        while(Cache::get('user_token:' . $user->id . "_" . $uniqid)){
            $uniqid = Str::random(16);
        }
        
        Log::info($user->id . "_" . $uniqid);
        $expireDate = now()->addMinutes($validTokenTime);
        Cache::put('user_token:' . $user->id . "_" . $uniqid, $token, $expireDate);      

        return response()->json([
            'access_token' => $token,
            'user_id' => $user->id,
            'expire_date' => $expireDate->toCookieString(),
            'cache_id' => $uniqid,
        ]);
    }
}
