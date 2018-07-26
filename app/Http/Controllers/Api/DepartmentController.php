<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;
use App\Http\Resources\DepartmentCollection;
use App\Http\Resources\Department as DepartmentResource;

class DepartmentController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        //return Department::withTrashed()->get();
        //return new DepartmentCollection(Department::with('company')->get());
        //return Department::with('company')->get();
        return Department::with('company')->paginate(10);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|min:3|max:120',
            'short_name'=>'required|max:10|min:3|unique:departments',
            'company_id' => 'required'
        ]);

        $department = Department::create([
            "name" => $request['name'],
            "short_name" => $request['short_name'],
            "company_id" => $request['company_id']
        ]);

        return new DepartmentResource($department);
    }

    public function show($id)
    {
        //return Department::findOrFail($id);
        return new DepartmentResource(Department::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required|min:3|max:120',
            'short_name'=>'required|max:10|min:3',
            'company_id' => 'required'
        ]);

        $department = Department::findOrFail($id);
        $department->name = $request['name'];
        $department->short_name = $request['short_name'];
        $department->company_id = $request['company_id'];
        $department->save();

        return new DepartmentResource($department);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return new DepartmentResource($department);
    }

    public function restore($id)
    {
        $department = Department::onlyTrashed()->findOrFail($id);
        $department->restore();

        return new DepartmentResource($department);
    }
}
