<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\Employee as EmployeeResource;
use App\Http\Resources\EmployeeList;
use Auth;
class EmployeeController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        if (Auth::user()->can('restore-employee') ){
            return new EmployeeCollection(Employee::withTrashed()->paginate(50));
        } else {
            return new EmployeeCollection(Employee::paginate(50));
        }
    }

    public function list()
    {
        return EmployeeList::collection(Employee::active()->get());
    }

    public function listManager()
    {
        return EmployeeResource::collection(Employee::active()->manager()->get());
    }

    public function show($id)
    {
        return new EmployeeResource(Employee::findOrFail($id));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100',
            'employee_id'=>'required|max:10',
            'location_id' => 'required',
            'positions' => 'required',
            'type' => 'required',
            'active' => 'required',
            'mobile'=>'max:30',
            'phone'=>'max:30'
        ]);

        $employee = new Employee();

        $employee->first_name = $request['first_name'];
        $employee->last_name = $request['last_name'];
        $employee->location_id = $request['location_id'];
        $employee->manager_id = $request['manager_id'];
        $employee->employee_id = $request['employee_id'];
        $employee->department_id = $request['department_id'];
        $employee->mobile = $request['mobile'];
        $employee->phone = $request['phone'];

        $employee->type = $request['type'];

        $employee->active = $request['active'];
        $employee->save();

        $positions = $request['positions'];
        $posId = [];
        foreach($positions as $position){
            $posId[] = $position['id'];
        }
        if (isset($posId)) {
            $employee->positions()->sync($posId);
            activity('system')
                ->performedOn($employee)
                ->causedBy(Auth::user())
                ->withProperties([
                    'name' => 'position',
                    'new' => $posId, 
                    'user_id' => Auth::user()->id,
                ])
                ->log('sync');
        }        

        return new EmployeeResource($employee);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'employee_id'=>'required|max:10',
            'location_id'=>'required',
            'mobile'=>'max:30',
            'phone'=>'max:30'
        ]);
        $employee = Employee::findOrFail($id);
        $employee->first_name = $request['first_name'];
        $employee->last_name = $request['last_name'];
        $employee->employee_id = $request['employee_id'];
        $employee->mobile = $request['mobile'];
        $employee->phone = $request['phone'];
        $employee->location_id = $request['location_id'];
        $employee->department_id = $request['department_id'];
        $employee->type = $request['type'];
        $employee->save();

        $positions = $request['positions'];
        $posId = [];
        $posOld = [];
        $olds = $employee->positions;
        foreach($olds as $o){
            $posOld[] = $o['id'];
        }
        foreach($positions as $position){
            $posId[] = $position['id'];
        }
        $diff = collect($posId)->diff(collect($posOld));
        if ($diff){
            if (isset($posId)) {
                $employee->positions()->sync($posId);
                activity('system')
                    ->performedOn($employee)
                    ->causedBy(Auth::user())
                    ->withProperties([
                        'name' => 'position',
                        'old' => $posOld,
                        'new' => $posId, 
                        'user_id' => Auth::user()->id,
                    ])
                    ->log('sync');
            }        
            else {
                $employee->positions()->detach();
                activity('system')
                    ->performedOn($employee)
                    ->causedBy(Auth::user())
                    ->withProperties([
                        'name' => 'position',
                        'old' => $posOld,
                        'new' => $posId,
                        'user_id' => Auth::user()->id,
                    ])
                    ->log('detach');
            }
        }   

        return new EmployeeResource($employee);

    }

}
