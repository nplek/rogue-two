<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\RoleList;

class RoleController extends Controller
{
    public function __construct() {
    }

    public function index() {
        return new RoleCollection(Role::paginate(20));
    }

    public function list()
    {
        return RoleList::collection(Role::all());
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name'=>'required|max:50|unique:roles',
            'permissions' =>'required',
            ]
        );

        $role = new Role();
        $role->name = $request['name'];
        $role->display_name = $request['display_name'];
        $role->save();
        $permissions = $request['permissions'];
        
        $role->attachPermissions($permissions);
        
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

        $permissions = $request['permissions'];
        $role->syncPermissions($permissions);

        return new RoleResource($role);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return new RoleResource($role);
    }
}
