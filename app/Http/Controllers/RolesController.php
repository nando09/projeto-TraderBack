<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Permission;
use App\Role;
use Illuminate\Support\Facades\Hash;


class RolesController extends Controller
{
    public function updateRole(Request $request, $id){
        $data = $request->all();
        $role = Role::find($id);
        $role->update([
            'name' => $data['name'],
        ]);
        $role->permissions()->detach();
        foreach($data['permissions'] as $modal_permission){
            $permission = Permission::find($modal_permission);
            $role->permissions()->attach($permission);
        }
        return $role;
    }
    public function getAllRoles(){
        $all_roles = Role::all();
        foreach($all_roles as $key => $role){

            $all_roles[$key]->permissions = $role->permissions()->get()->pluck('name');
            $all_roles[$key]->users = $role->users()->get()->pluck('name');

        }


        return $all_roles;

    }

    public function getAllPermissions(){

        $all_permissions = Permission::all();
        return $all_permissions;

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
