<?php

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Router::post('/login', 'UserController@login');

Route::post('/login', "LoginController@login")->name('login');


Route::middleware('auth:api')->group(function(){

    Route::prefix('/roles')->group(function(){
        Route::get('/auth-roles', "RolesController@getAuthRoles");
        Route::get('/all-roles', "RolesController@getAllRoles");
    });

    Route::post('/register', "RegisterController@register")->name('register');
});
