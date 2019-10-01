<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


class LoginController extends Controller
{
    public function login(Request $request){
        $data  = $request->all();
        
        $validator = Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()){
            return $validator->errors();
        }
        
        if (Auth::attempt(["email"=>$data['email'], "password"=>$data['password']])){
            
            $user = Auth::user();            
            $user->token = $user->createToken($user->email)->accessToken;
            return $user;
        }
        
        return ["status" => false];
    }

}
