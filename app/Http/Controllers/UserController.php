<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


class UserController extends Controller
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
            $user = auth()->user();
            $user->token = $user->createToken($user->email)->accessToken;
            return $user;
        }
        return ["status" => false];
    }

    public function register(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if ($validator->fails()){
            return $validator->errors();
        }

        $user =  User::create([

            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        $user->token = $user->createToken($user->email)->accessToken;
        return $user;
    }
}
