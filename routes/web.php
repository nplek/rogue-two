<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/', function(){
    //return redirect('/welcome');
    return redirect('/login');
})->name('index');

Auth::routes();
Route::group(['middleware' => ['role:super|admin|user']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboards', 'DashboardController@index')->name('dashboard');
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/roles', 'RoleController@index')->name('roles.index');
    Route::get('/passports', 'RoleController@passport')->name('roles.passport');
    Route::get('/permissions', 'PermissionController@index')->name('permissions.index');
    Route::get('/teams', 'TeamController@index')->name('teams.index');
    Route::get('/activitylogs', 'LogController@activityLogIndex')->name('logs.activity.index');
    Route::get('/accesslogs', 'LogController@accessLogIndex')->name('logs.access.index');
    Route::get('/securitylogs', 'LogController@securityLogIndex')->name('logs.security.index');
    Route::get('/companies', 'CompanyController@index')->name('companies.index');
    Route::get('/departments', 'DepartmentController@index')->name('departments.index');
    Route::get('/locations', 'LocationController@index')->name('locations.index');
    Route::get('/employees', 'UserController@employee')->name('employees.index');
    Route::get('/positions', 'PositionController@index')->name('positions.index');
    Route::get('/projects', 'ProjectController@index')->name('projects.index');

});
Route::get('/errors/400', 'ErrorController@page400')->name('errors.400');
Route::get('/errors/403', 'ErrorController@page403')->name('errors.403');