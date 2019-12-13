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
Route::post('/client/register', 'RegisterController@RegisterClient')->name('clientRegister');

Route::middleware('auth:api')->group(function(){

    Route::prefix('/betfair')->group(function() {
        Route::post('/login', 'BetFairController@login');
        Route::post('/liveEvents', 'BetFairController@getLiveEvents');
        Route::post('/nextEvents', 'BetFairController@getNextGames');

        Route::post('/todayOdds', 'BetFairController@todayOdds');
        Route::post('/tmOdds', 'BetFairController@tomorrowOdds');
        Route::post('/nextOdds', 'BetFairController@nextOdds');
    });
//    Rotas de organização de roles
    Route::prefix('/roles')->group(function(){
        Route::get('/auth-roles', "RolesController@getAuthRoles");
        Route::get('/all-roles', "RolesController@getAllRoles");
        Route::get('/all-permissions', "RolesController@getAllPermissions");

        Route::put('/update/{id}', 'RolesController@updateRole');

    });

//Rotas de organização de curso
    Route::prefix('/course')->group(function(){
        Route::post('/create', 'CoursesController@createCourse');
        Route::put('/update/{id}', 'CoursesController@updateCourse');
        Route::post('/destroy', 'CoursesController@destroyCourse');
    });

    Route::prefix('/module')->group(function(){
        Route::post('/create', 'CoursesController@createModule');
        Route::put('/update/{id}', 'CoursesController@updateModule');
        Route::post('/destroy', 'CoursesController@destroyModule');

    });

    Route::prefix('/lesson')->group(function(){
        Route::post('/create', 'CoursesController@createLesson');
        Route::put('/update/{id}', 'CoursesController@updateLesson');
        Route::post('/destroy', 'CoursesController@destroyLesson');

    });

//    Rotas de Listagem de cursos
    Route::prefix('/courses')->group(function(){

        Route::get('/all-courses', "CoursesController@getAllCourses");

        Route::prefix('/{course_id}')->group(function(){
            Route::get('/modules', 'CoursesController@getCourseModules');
            Route::get('/module/{module_id}', 'CoursesController@getModuleLessons');
        });

    });

    Route::post('/register', "RegisterController@register")->name('register');

});
