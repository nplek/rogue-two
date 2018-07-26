<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\Role as RoleResource;

class RoleController extends Controller
{
    public function __construct() {
    }

    public function index() {
        return new RoleCollection(Role::all());
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name'=>'required|max:50|unique:roles',
            'permissions' =>'required',
            ]
        );

        $name = $request['name'];
        $display_name = $request['display_name'];
        $description = $request['description'];

        $role = new Role();
        $role->name = $name;
        $role->display_name = $display_name;
        $role->description = $description;
        $role->save();
        $permissions = $request['permissions'];
        $role->attachPermissions($permissions);

        /*foreach($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail();
            $role->attachPermission($p);
        }*/
        return $role;
    }

    public function show($id) {
        return new RoleResource(Role::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name'=>'required|max:50,'.$id,
            'permissions' =>'required',
            ]
        );
        $role = Role::findOrFail($id);
        $name = $request['name'];
        $display_name = $request['display_name'];
        $description = $request['description'];
        
        $role->name = $name;
        $role->display_name = $display_name;
        $role->description = $description;
        $role->save();

        $p_all = Permission::all();//Get all permissions

        $permissions = $request['permissions'];
        $role->syncPermissions($permissions);
        /*foreach ($p_all as $p) {
            $role->detachPermission($p); //Remove all permissions associated with role
        }

        foreach ($permissions as $permission) {
            $p = Permission::where('id', '=', $permission)->firstOrFail(); //Get corresponding form //permission in db
            $role->attachPermission($p);  //Assign permission to role
        }*/

        return new RoleResource($role);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        //\LogActivity::addToLog('Delete role success.');
        return new RoleResource($role);
    }
}
