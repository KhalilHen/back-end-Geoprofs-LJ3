<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;//depends on model

use Illuminate\Support\Facades\Hash;


class log_in_controller extends Controller
{
    public function logIn(Request $request)
    {
        $request->validate([
            'emailOrId' => 'required|string',//can be id or email
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->emailOrId)->first();//depends on model

        if(is_null($user)){
            $user = User::where('id', $request->emailOrId)->first();//depends on model
        }

        //log in attempts limiter need to be added

        if(is_null($user) || Hash::check($request->password, $user->password)){

            //error message for return needs to be added
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        
        $token = $user->createToken('auth_token')->plainTextToken;
        //token with users id needs to be stored

        return response()->json([
            'access_token' => $token,
            'user_id' => $user->id,
        ]);
    }
}
