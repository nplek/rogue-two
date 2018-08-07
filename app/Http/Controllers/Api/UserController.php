<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\UserCollection;
use App\Http\Resources\User as UserResource;
use App\RoleUser;
use App\Http\Resources\RoleUser as RoleUserResource;
use App\Team;
use App\Role;
use Auth;

class UserController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        if (Auth::user()->can('restore-user') ){
            return new UserCollection(User::withTrashed()->paginate(50));
        } else {
            return new UserCollection(User::paginate(50));
        }
    }

    public function list()
    {
        return UserResource::collection(User::active()->get());
    }

    public function listManager()
    {
        return UserResource::collection(User::active()->get());
    }

    public function listUserRole($id)
    {
        return RoleUserResource::collection(RoleUser::where('user_id','=',$id)->get());
    }
    public function showUserRole($uid,$rid)
    {
        return new RoleUserResource(RoleUser::where('user_id','=',$uid)->where('role_id','=',$rid)->first());
    }

    public function storeUserRole(Request $request, $uid)
    {
        $this->validate($request, [
            'role_id' => 'required',
            'team_id'=>'required',
        ]);

        
        $team_id = $request['team_id'];
        $role_id = $request['role_id'];
        $team = Team::where('id','=',$team_id)->first();
        $role = Role::where('id','=',$role_id)->first();
        $user = User::findOrFail($uid);

        $user->attachRole($role,$team);
        $roleUser = RoleUser::where('user_id','=',$uid)
            ->where('role_id','=',$role_id)
            ->where('team_id','=',$team_id)
            ->first();
        return new RoleUserResource($roleUser);
    }
    public function destroyUserRole(Request $request, $uid,$rid,$tid)
    {
        $user = User::findOrFail($uid);
        $team = Team::where('id','=',$tid)->first();
        $role = Role::where('id','=',$rid)->first();
        $user->detachRole($role,$team);

        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|alpha_dash|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'min:6|confirmed',
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
        ]);

        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        if ($request['password']) {
            $user->password = $request['password'];
        } else {
            $user->password = str_random(10);
        }
        $user->location_id = $request['location_id'];
        $user->manager_id = $request['manager_id'];
        $user->employee_id = $request['employee_id'];
        $user->mobile = $request['mobile'];
        $user->phone = $request['phone'];

        $user->active = $request['active'];
        $user->save();

        /*$roles = $request['roles'];
        if (isset($roles)) {
            $user->attachRoles($roles);
        }*/
        $positions = $request['positions'];
        $posId = [];
        foreach($positions as $position){
            $posId[] = $position['id'];
        }
        if (isset($posId)) {
            $user->positions()->sync($posId);
            activity('system')
                ->performedOn($user)
                ->causedBy(Auth::user())
                ->withProperties([
                    'name' => 'position',
                    'new' => $posId, 
                    'user_id' => $user->id,
                ])
                ->log('sync');
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
            'email'=>'required|email',
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->location_id = $request['location_id'];
        $user->manager_id = $request['manager_id'];
        
        $user->employee_id = $request['employee_id'];
        $user->mobile = $request['mobile'];
        $user->phone = $request['phone'];
        $user->active = $request['active'];
        if ($request['password']) {
            $user->password = $request['password'];
        }
        $user->save();

        /*$roles = $request['roles'];
        $user->syncRoles($roles);*/
        $positions = $request['positions'];
        $posId = [];
        $posOld = [];
        $olds = $user->positions;
        foreach($olds as $o){
            $posOld[] = $o['id'];
        }
        foreach($positions as $position){
            $posId[] = $position['id'];
        }
        $diff = collect($posId)->diff(collect($posOld));
        if ($diff){
            if (isset($posId)) {
                $user->positions()->sync($posId);
                activity('system')
                    ->performedOn($user)
                    ->causedBy(Auth::user())
                    ->withProperties([
                        'name' => 'position',
                        'old' => $posOld,
                        'new' => $posId, 
                        'user_id' => $user->id,
                    ])
                    ->log('sync');
            }        
            else {
                $user->positions()->detach();
                activity('system')
                    ->performedOn($user)
                    ->causedBy(Auth::user())
                    ->withProperties([
                        'name' => 'position',
                        'old' => $posOld,
                        'new' => $posId,
                        'user_id' => $user->id,
                    ])
                    ->log('detach');
            }
        }
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
