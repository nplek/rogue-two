<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\UserCollection;
use App\Http\Resources\User as UserResource;

class EmployeeController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        return new UserCollection(User::paginate(50));
    }

    public function list()
    {
        return UserResource::collection(User::active()->get());
    }

    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    public function update(Request $request, $id)
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
        $positions = $request['positions'];
        $user->save();

        if (isset($departments)) {
            $user->departments()->sync($departments);
        }        
        else {
            $user->departments()->detach();
        }

        return new UserResource($user);

    }

}
