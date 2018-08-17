<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ItemUnit;
use App\Http\Resources\ItemUnitCollection;
use App\Http\Resources\ItemUnit as ItemUnitResource;
use Auth;

class ItemUnitController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        if (Auth::user()->can('restore-item') ){
            return new ItemUnitCollection(ItemUnit::withTrashed()->paginate(50));
        } else {
            return new ItemUnitCollection(ItemUnit::paginate(50));
        }
    }

    public function list()
    {
        return ItemUnitResource::collection(ItemUnit::active()->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|min:3|max:10|unique:item_units',
        ]);

        $item = new ItemUnit();
        $item->name = $request['name'];
        $item->save();

        return new ItemUnitResource($item);
    }

    public function show($id)
    {
        return new ItemUnitResource(ItemUnit::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required|min:3|max:10',
        ]);
        $item = ItemUnit::findOrFail($id);
        $item->name = $request['name'];
        $item->save();

        return new ItemUnitResource($item);
    }

    public function destroy($id)
    {
        $item = ItemUnit::findOrFail($id);
        $item->delete();
        return new ItemUnitResource($item);
    }

    public function restore($id)
    {
        $item = ItemUnit::onlyTrashed()->findOrFail($id);
        $item->restore();

        return new ItemUnitResource($item);
    }
}
