<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ItemGroup;
use App\Http\Resources\ItemGroupCollection;
use App\Http\Resources\ItemGroup as ItemGroupResource;
use Auth;

class ItemGroupController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        if (Auth::user()->can('restore-item') ){
            return new ItemGroupCollection(ItemGroup::withTrashed()->paginate(50));
        } else {
            return new ItemGroupCollection(ItemGroup::paginate(50));
        }
    }

    public function list()
    {
        return ItemGroupResource::collection(ItemGroup::active()->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'short_name'=>'required|min:3|max:10|unique:item_groups',
            'name'=>'required|min:3|max:50',
        ]);

        $item = new ItemGroup();
        $item->name = $request['name'];
        $item->short_name = $request['short_name'];
        $item->save();

        return new ItemGroupResource($item);
    }

    public function show($id)
    {
        return new ItemGroupResource(ItemGroup::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required|min:3|max:10',
            'name'=>'required|min:3|max:50',
        ]);
        $item = ItemGroup::findOrFail($id);
        $item->name = $request['name'];
        $item->short_name = $request['short_name'];
        $item->save();

        return new ItemGroupResource($item);
    }

    public function destroy($id)
    {
        $item = ItemGroup::findOrFail($id);
        $item->delete();
        return new ItemGroupResource($item);
    }

    public function restore($id)
    {
        $item = ItemGroup::onlyTrashed()->findOrFail($id);
        $item->restore();

        return new ItemGroupResource($item);
    }
}
