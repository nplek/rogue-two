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

/*Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::group(['middleware' => 'auth:api'], function(){
    Route::namespace('Api')->group(function(){
        Route::name('api.')->group(function(){
            Route::resource('companies', 'CompanyController',['except' => ['create','edit']]);
            /*Route::resource('companies', 'CompanyController',['except' => ['create','edit']])
            ->middleware('scopes:super-web,admin-web');*/
            Route::post('companies/{id}/restore','CompanyController@restore')->name('companies.restore');
            Route::post('companies/list','CompanyController@list')->name('companies.list');

            Route::resource('departments', 'DepartmentController',['except' => ['create','edit']]);
            Route::post('departments/{id}/restore','DepartmentController@restore')->name('departments.restore');
            Route::post('departments/list','DepartmentController@list')->name('departments.list');
            Route::resource('locations', 'LocationController',['except' => ['create','edit']]);
            Route::post('locations/{id}/restore','LocationController@restore')->name('locations.restore');
            Route::post('locations/list','LocationController@list')->name('locations.list');
            Route::resource('projects', 'ProjectController',['except' => ['create','edit']]);
            Route::post('projects/{id}/restore','ProjectController@restore')->name('projects.restore');
            Route::post('projects/list','ProjectController@list')->name('projects.list');

            Route::resource('users', 'UserController',['except' => ['create','edit']]);
            Route::post('users/{id}/restore','UserController@restore')->name('users.restore');
            Route::post('users/list','UserController@list')->name('users.list');
            Route::put('users/{id}/reset', 'UserController@reset_update')->name('users.reset');
            Route::put('users/{id}/active', 'UserController@active_user')->name('users.active');
            Route::put('users/{id}/inactive', 'UserController@inactive_user')->name('users.inactive');

            Route::resource('employees', 'EmployeeController',['except' => ['create','edit','store','destroy']]);
            Route::post('employees/list','EmployeeController@list')->name('employees.list');

            Route::resource('roles', 'RoleController',['except' => ['create','edit']]);
            Route::post('roles/list','RoleController@list')->name('roles.list');
            Route::resource('permissions', 'PermissionController',['except' => ['create','edit']]);
            Route::post('permissions/list','PermissionController@list')->name('permissions.list');
            Route::resource('teams', 'TeamController',['except' => ['create','edit']]);
            Route::post('teams/list','TeamController@list')->name('teams.list');
            //Route::resource('logs', 'LogController',['except' => ['create','edit','show','store','update','destroy']]);
            Route::get('logs/activitylogs', 'LogController@activityLogsIndex')->name('logs.activity.index');
            Route::get('logs/accesslogs', 'LogController@accessLogsIndex')->name('logs.access.index');
            Route::get('logs/securitylogs', 'LogController@securityLogsIndex')->name('logs.security.index');
            Route::delete('logs/{id}', 'LogController@destroyLog')->name('logs.delete');

            Route::resource('positions', 'PositionController',['except' => ['create','edit']]);
            Route::post('positions/{id}/restore','PositionController@restore')->name('positions.restore');
            Route::post('positions/list','PositionController@list')->name('positions.list');
        });
    });
});