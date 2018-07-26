<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Team;
use App\Http\Resources\TeamCollection;
use App\Http\Resources\Team as TeamResource;

class TeamController extends Controller
{
    public function __construct() {
    }

    public function index() {
        return new TeamCollection(Team::all());
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name'=>'required|max:50|unique:teams',
            ]
        );

        $name = $request['name'];
        $display_name = $request['display_name'];
        $description = $request['description'];

        $team = new Team();
        $team->name = $name;
        $team->display_name = $display_name;
        $team->description = $description;
        $team->save();
        
        return new TeamResource($team);
    }

    public function show($id) {
        return new TeamResource(Role::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name'=>'required|max:50,'.$id,
            ]
        );
        $team = Team::findOrFail($id);
        $name = $request['name'];
        $display_name = $request['display_name'];
        $description = $request['description'];
        
        $team->name = $name;
        $team->display_name = $display_name;
        $team->description = $description;
        $team->save();

        return new TeamResource($role);
    }

    public function destroy($id)
    {
        $team = Team::findOrFail($id);
        $team->delete();
        //\LogActivity::addToLog('Delete role success.');
        return new TeamResource($role);
    }
}
