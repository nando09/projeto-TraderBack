<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


class RolesController extends Controller
{
    public function getAllRoles(){
        $all_roles = Role::all();
        foreach($all_roles as $key => $role){

            $all_roles[$key]->permissions = $role->permissions()->get()->pluck('name');
            $all_roles[$key]->users = $role->users()->get()->pluck('name');

        }


        return $all_roles;

    }

    public function getAuthRoles(){

        return Auth::user()->roles()->get()->pluck('name');

    }

    public function rolePermissions(){
        foreach(Role::all() as $role){
            $role->permissions()->get()->pluck('name');
        }
//        return $role->permissions()->get()->pluck('name');
    }

    public function hasAnyRoles($roles){

        return null !== $this.roles()->whereIn('name', $roles)->first();

    }

}
