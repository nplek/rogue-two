<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\Company as CompanyResource;

class CompanyController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        //authen check
        return Company::withTrashed()->paginate(10);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|min:3|max:120',
            'short_name'=>'required|max:10|min:3|unique:companies'
        ]);

        $company = Company::create([
            "name" => $request['name'],
            "short_name" => $request['short_name'],
        ]);

        return new CompanyResource($company);
    }

    public function show($id)
    {
        //return Company::findOrFail($id);
        return new CompanyResource(Company::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required|max:120',
            'short_name'=>'required|max:10|min:3',
        ]);
        //\Auth::user()->activity;
        $company = Company::findOrFail($id);
        $company->name = $request['name'];
        $company->short_name = $request['short_name'];
        //$company->activity()->causedBy(auth()->user());
        $company->save();
        /*activity('myapp')
        ->withProperties([
            'ip' => $request->ip(), 
            'method' => $request->method(),
            'agent'  => $request->header('user-agent'),
            'user_id' => auth()->check() ? auth()->user()->id : 1,
            'url' => $request->fullUrl()
        ])
        ->log('update success');*/

        
        
        return new CompanyResource($company);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return new CompanyResource($company);
    }

    public function restore(Request $request,$id)
    {
        $company = Company::onlyTrashed()->findOrFail($id);
        $company->restore();

        return new CompanyResource($company);
    }
}
