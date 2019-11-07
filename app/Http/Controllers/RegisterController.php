<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


class RegisterController extends Controller
{

    public function register(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],[
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O email não é valido',
            'password.required' => 'A senha é obrigatória'
        ]);

        if ($validator->fails()){
            return $validator->errors();
        }
        $role = Role::where('name', $data['role'])->first();
        $user =  User::create([

            'name' => $data['name'],
            'role_id' => $role->id,
            'email' => $data['email'],
            'password' => Hash::make($data['password'])

        ]);

        $user->role()->associate($role);
        $user->token = $user->createToken($user->email)->accessToken;
        return $user;
    }

    public function registerClient(Request $request){
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ],[
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'O email não é valido',
            'password.required' => 'A senha é obrigatória'
        ]);

        if ($validator->fails()){
            $validator->errors()->add('status', false);
            return $validator->errors();
        }

        $user =  User::create([

            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => 4,
            'password' => Hash::make($data['password'])

        ]);
        $role = Role::where('name', 'Client')->first();
        $user->role()->associate($role);
        $user->token = $user->createToken($user->email)->accessToken;
        return $user;
    }
}
