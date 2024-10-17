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

        if(is_null($user) || Hash::check($request->password, $user->password)){
            return(Null);//if login was not successful return stops code from continuing
        }

        return(Null);//if login was successful
    }
}
