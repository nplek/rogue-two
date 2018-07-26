<?php

use Illuminate\Http\Request;

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
Route::post('login', 'API\LoginController@login')->name('api.login');

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
//Route::group(['middleware' => 'auth:api'], function(){
    Route::namespace('Api')->group(function(){
        Route::name('api.')->group(function(){
            Route::resource('companies', 'CompanyController',['except' => ['create','edit']]);
            Route::post('companies/{id}/restore','CompanyController@restore')->name('companies.restore');
            Route::resource('departments', 'DepartmentController',['except' => ['create','edit']]);
            Route::post('departments/{id}/restore','DepartmentController@restore')->name('departments.restore');
            Route::resource('locations', 'LocationController',['except' => ['create','edit']]);
            Route::post('locations/{id}/restore','LocationController@restore')->name('locations.restore');
            Route::resource('projects', 'ProjectController',['except' => ['create','edit']]);
            Route::post('projects/{id}/restore','ProjectController@restore')->name('projects.restore');

            Route::resource('users', 'UserController',['except' => ['create','edit']]);
            Route::post('users/{id}/restore','UserController@restore')->name('users.restore');
            Route::put('users/{id}/reset', 'UserController@reset_update')->name('users.reset');
            Route::put('users/{id}/active', 'UserController@active_user')->name('users.active');
            Route::put('users/{id}/inactive', 'UserController@inactive_user')->name('users.inactive');

            Route::resource('roles', 'RoleController',['except' => ['create','edit']]);
            Route::resource('teams', 'TeamController',['except' => ['create','edit']]);

            Route::resource('positions', 'PositionController',['except' => ['create','edit']]);
            Route::post('positions/{id}/restore','PositionController@restore')->name('positions.restore');
        });
    });
//});