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

        return Role::all();

    }

    public function getAuthRoles(){

        return Auth::user()->roles()->get()->pluck('name');

    }

    public function hasAnyRoles($roles){

        return null !== $this.roles()->whereIn('name', $roles)->first();

    }

}
