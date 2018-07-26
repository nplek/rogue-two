<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\UserCollection;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        //return new UserCollection(User::get());
        //return User::withTrashed()->paginate(10);
        return User::paginate(10);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|alpha_dash|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed'
        ]);

        $user = User::create($request->only('email', 'name', 'password'));

        $roles = $request['roles'];
        if (isset($roles)) {
            $user->attachRoles($roles);
        }

        return new UserResource($user);
    }

    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required|alpha_dash|max:120',
            'email'=>'required|email|unique:users,email,'.$id
        ]);

        $user = User::findOrFail($id);
        $input = $request->only(['name', 'email']);
        $user->fill($input)->save();

        $roles = $request['roles'];

        $user->syncRoles($roles);

        return new UserResource($user);
    }

    public function updateProfile(Request $request, $id)
    {
        $this->validate($request, [
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'employee_id'=>'required|max:10',
            'mobile'=>'max:30',
            'phone'=>'max:30'
        ]);
        $user = User::findOrFail($id);
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->employee_id = $request['employee_id'];
        $user->mobile = $request['mobile'];
        $user->phone = $request['phone'];
        $user->location_id = $request['location'];
        $departments = $request['departments'];
        $user->save();

        if (isset($departments)) {
            $user->departments()->sync($departments);
        }        
        else {
            $user->departments()->detach();
        }

        return new UserResource($user);

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id); 
        $user->active = 'I';
        $user->delete();

        return new UserResource($user);
    }

    public function restore($id){
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return new UserResource($user);
    }

    public function active_user($id){
        $user = User::findOrFail($id);
        $user->active = 'A';
        $user->save();
        
        return new UserResource($user);
    }

    public function inactive_user($id){
        $user = User::findOrFail($id);
        $user->active = 'I';
        $user->save();
        
        return new UserResource($user);
    }

    public function reset_update(Request $request, $id)
    {
        $this->validate($request, [
            'password'=>'required|min:6|confirmed'
        ]);
        $user = User::findOrFail($id);
        $input = $request->only(['password']);
        $user->fill($input)->save();
        
        return new UserResource($user);
    }

}
