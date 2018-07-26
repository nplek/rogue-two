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

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/dashboards', 'DashboardController@index')->name('dashboard');
    Route::get('/users', 'UserController@index')->name('users.index');
    Route::get('/companies', 'CompanyController@index')->name('companies.index');
    Route::get('/departments', 'DepartmentController@index')->name('departments.index');
    Route::get('/locations', 'LocationController@index')->name('locations.index');
    Route::get('/employees', 'UserController@employee')->name('employees.index');
    Route::get('/positions', 'PositionController@index')->name('positions.index');
    Route::get('/projects', 'ProjectController@index')->name('projects.index');
});