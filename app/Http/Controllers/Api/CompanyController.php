<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\Company as CompanyResource;
use Auth;
class CompanyController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        if (Auth::user()->can('restore-company') ){
            return new CompanyCollection(Company::withTrashed()->paginate(50));
        } else {
            return new CompanyCollection(Company::paginate(50));
        }
    }

    public function list()
    {
        return CompanyResource::collection(Company::active()->get());
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
            'active' => $request['active'],
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
        $company->active = $request['active'];
        $company->save();
        
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
