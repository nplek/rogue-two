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
            Route::get('users/roles/{id}','UserController@listUserRole')->name('users.roles.list');
            Route::get('users/roles/{uid}/{rid}','UserController@showUserRole')->name('users.roles.show');
            Route::post('users/roles/{uid}','UserController@storeUserRole')->name('users.roles.create');
            Route::delete('users/roles/{uid}/{rid}/{tid}','UserController@destroyUserRole')->name('users.roles.delete');
            Route::post('users/passport/{uid}','UserController@reset_passport')->name('users.passport.reset');
            

            Route::resource('employees', 'EmployeeController',['except' => ['create','edit']]);
            Route::post('employees/manager/list','EmployeeController@listManager')->name('employees.manager.list');
            Route::post('employees/staff/list','EmployeeController@listStaff')->name('employees.staff.list');
            Route::post('employees/list','EmployeeController@list')->name('employees.list');

            Route::resource('roles', 'RoleController',['except' => ['create','edit']]);
            Route::post('roles/list','RoleController@list')->name('roles.list');
            
            Route::resource('permissions', 'PermissionController',['except' => ['create','edit']]);
            Route::post('permissions/list','PermissionController@list')->name('permissions.list');
            
            Route::resource('teams', 'TeamController',['except' => ['create','edit']]);
            Route::post('teams/list','TeamController@list')->name('teams.list');
            
            Route::get('logs/activitylogs', 'LogController@activityLogsIndex')->name('logs.activity.index');
            Route::get('logs/accesslogs', 'LogController@accessLogsIndex')->name('logs.access.index');
            Route::get('logs/securitylogs', 'LogController@securityLogsIndex')->name('logs.security.index');
            Route::delete('logs/{id}', 'LogController@destroyLog')->name('logs.delete');

            Route::resource('positions', 'PositionController',['except' => ['create','edit']]);
            Route::post('positions/{id}/restore','PositionController@restore')->name('positions.restore');
            Route::post('positions/list','PositionController@list')->name('positions.list');

            Route::resource('items', 'ItemController',['except' => ['create','edit']]);
            Route::post('items/{id}/restore','ItemController@restore')->name('items.restore');
            Route::post('items/list','ItemController@list')->name('items.list');

            Route::get('items/uom/{id}','ItemController@listUOM')->name('items.uom.list');
            Route::get('items/uom/{id}/{uid}','ItemController@showUOM')->name('items.uom.show');
            Route::post('items/uom/{id}','ItemController@storeUOM')->name('items.uom.create');
            Route::delete('items/uom/{id}/{uid}','ItemController@destroyUOM')->name('items.uom.delete');

            Route::resource('itemunits', 'ItemUnitController',['except' => ['create','edit']]);
            Route::post('itemunits/{id}/restore','ItemController@restore')->name('itemunits.restore');
            Route::post('itemunits/list','ItemUnitController@list')->name('itemunits.list');

            Route::resource('itemgroups', 'ItemGroupController',['except' => ['create','edit']]);
            Route::post('itemgroups/{id}/restore','ItemGroupController@restore')->name('itemgroups.restore');
            Route::post('itemgroups/list','ItemGroupController@list')->name('itemgroups.list');

            Route::resource('inventories', 'InventoryController',['except' => ['create','edit']]);
            Route::post('inventories/{id}/restore','InventoryController@restore')->name('inventories.restore');
            Route::post('inventories/list','InventoryController@list')->name('inventories.list');
            Route::get('inventories/items/{whs_id}','InventoryController@findItemByWhs')->name('inventories.list.itemwhs');

            Route::resource('goodsreceipts', 'GoodsReceiptController',['except' => ['create','edit']]);
            Route::post('goodsreceipts/list','GoodsReceiptController@list')->name('goodsreceipts.list');
            Route::get('goodsreceipts/{item_id}/items/{whs_id}','GoodsReceiptController@findItemByWhs')->name('goodsreceipts.list.itemwhs');
            Route::post('goodsreceipts/docnum','GoodsReceiptController@dummyDoc')->name('goodsreceipts.docnum');

            Route::resource('goodspos', 'GoodsReceiptPOController',['except' => ['create','edit']]);
            Route::post('goodspos/list','GoodsReceiptPOController@list')->name('goodspos.list');
            Route::get('goodspos/po/docnum/{docnum}','GoodsReceiptPOController@findPOByDocnum')->name('goodspos.list.docnum');
            Route::post('goodspos/docnum','GoodsReceiptPOController@dummyDoc')->name('goodspos.docnum');

            Route::resource('whs', 'WarehouseController',['except' => ['create','edit']]);
            Route::post('whs/{id}/restore','WarehouseController@restore')->name('whs.restore');
            Route::post('whs/list','WarehouseController@list')->name('whs.list');

            Route::resource('bps', 'BusinessPartnerController',['except' => ['create','edit']]);
            Route::post('bps/{id}/restore','BusinessPartnerController@restore')->name('bps.restore');
            Route::post('bps/list','BusinessPartnerController@list')->name('bps.list');

            Route::resource('goodsissues', 'GoodsIssueController',['except' => ['create','edit']]);
            Route::post('goodsissues/{id}/restore','GoodsIssueController@restore')->name('goodsissues.restore');
            Route::post('goodsissues/list','GoodsIssueController@list')->name('goodsissues.list');
            Route::get('goodsissues/{item_id}/items/{whs_id}','GoodsIssueController@findItemByWhs')->name('goodsissues.list.itemwhs');
            Route::post('goodsissues/docnum','GoodsIssueController@dummyDoc')->name('goodsissues.docnum');

            Route::resource('goodsreturns', 'GoodsReturnController',['except' => ['create','edit']]);
            Route::post('goodsreturns/list','GoodsReturnController@list')->name('goodsreturns.list');
            Route::get('goodsreturns/{item_id}/items/{whs_id}','GoodsReturnController@findItemByWhs')->name('goodsreturns.list.itemwhs');
            Route::post('goodsreturns/docnum','GoodsReturnController@dummyDoc')->name('goodsreturns.docnum');

            Route::resource('returnitems', 'ReturnItemController',['except' => ['create','edit']]);
            Route::post('returnitems/list','ReturnItemController@list')->name('returnitems.list');
            Route::get('returnitems/{item_id}/items/{whs_id}','ReturnItemController@findItemByWhs')->name('returnitems.list.itemwhs');
            Route::post('returnitems/docnum','ReturnItemController@dummyDoc')->name('returnitems.docnum');

            Route::resource('tranitems', 'TransferItemController',['except' => ['create','edit']]);
            Route::post('tranitems/list','TransferItemController@list')->name('tranitems.list');
            Route::get('tranitems/{item_id}/items/{whs_id}','TransferItemController@findItemByWhs')->name('tranitems.list.itemwhs');
            Route::post('tranitems/docnum','TransferItemController@dummyDoc')->name('tranitems.docnum');

            Route::resource('adjustitems', 'AdjustItemController',['except' => ['create','edit']]);
            Route::post('adjustitems/list','AdjustItemController@list')->name('adjustitems.list');
            Route::get('adjustitems/{item_id}/items/{whs_id}','AdjustItemController@findItemByWhs')->name('adjustitems.list.itemwhs');
            Route::post('adjustitems/docnum','AdjustItemController@dummyDoc')->name('adjustitems.docnum');


            Route::get('purchaseorders/docnum/{docnum}','PurchaseController@findDocnum')->name('purchaseorders.docnum');
            Route::get('purchaseorders/docnum/list/{docnum}','PurchaseController@findDocnumList')->name('purchaseorders.list.docnum');
        });
    });
});