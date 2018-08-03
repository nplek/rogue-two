<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Project;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\Project as ProjectResource;

class ProjectController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        return new ProjectCollection(Project::withTrashed()->paginate(10));
    }

    public function list()
    {
        return ProjectResource::collection(Project::active()->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'project_code'=>'required|min:3|max:10|unique:projects',
            'name'=>'required|min:3|max:50',
            'budget' => 'required|between:0,999999999.99',
            'short_name' =>'required|min:2|max:8',
            'start_date' => 'required',
            'end_date' => 'required',
            'active' => 'required'
            ]
        );

        $project = new Project();
        $project->project_code = $request['project_code'];
        $project->name = $request['name'];
        $project->short_name = $request['short_name'];
        $project->budget = $request['budget'];
        $project->book_budget = 0;
        $project->available_budget = 0;
        $project->used_budget = 0;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $project->start_date = substr($start_date,0,10);
        $project->end_date = substr($end_date,0,10);
        $project->active = $request['active'];
        $project->save();


        return new ProjectResource($project);
    }

    public function show($id){
        return new ProjectResource(Project::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'project_code'=>'required|min:3|max:10',
            'name'=>'required|min:3|max:50',
            'budget' => 'required|between:0,999999999.99',
            'short_name' =>'min:2|max:8',
            'start_date' => 'required',
            'end_date' => 'required',
            ]
        );

        $project = Project::findOrFail($id);
        $project->project_code = $request['project_code'];
        $project->name = $request['name'];
        $project->short_name = $request['short_name'];
        $project->budget = $request['budget'];
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $project->start_date = substr($start_date,0,10);
        $project->end_date = substr($end_date,0,10);
        $project->active = $request['active'];
        $project->save();

        return new ProjectResource($project);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return new ProjectResource($project);
    }

    public function restore($id){
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();

        return new ProjectResource($project);
    }
}
