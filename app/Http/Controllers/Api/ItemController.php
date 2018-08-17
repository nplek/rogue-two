<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\Item as ItemResource;
use Auth;

class ItemController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        if (Auth::user()->can('restore-item') ){
            return new ItemCollection(Item::withTrashed()->paginate(50));
        } else {
            return new ItemCollection(Item::paginate(50));
        }
    }

    public function list()
    {
        return ItemResource::collection(Item::active()->get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'item_code'=>'required|max:20|min:3|unique:items',
            'name'=>'required|min:3|max:50',
        ]);

        $item = new Item();
        $item->item_code = $request['item_code'];
        $item->name = $request['name'];
        $item->description = $request['description'];
        //$item->item_group_id = $request['item_group_id'];
        $item->unit_name1 = $request['unit_name1'];
        $item->unit_qty1 = $request['unit_qty1'];
        $item->unit_name2 = $request['unit_name2'];
        $item->unit_qty2 = $request['unit_qty2'];
        $item->unit_name3 = $request['unit_name3'];
        $item->unit_qty3 = $request['unit_qty3'];
        $item->save();

        return new ItemResource($item);
    }

    public function show($id)
    {
        return new ItemResource(Item::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required|min:3|max:50',
        ]);
        $item = Item::findOrFail($id);
        //$item->name = $request['item_code'];
        $item->name = $request['name'];
        $item->description = $request['description'];
        //$item->item_group_id = $request['item_group_id'];
        $item->unit_name1 = $request['unit_name1'];
        $item->unit_qty1 = $request['unit_qty1'];
        $item->unit_name2 = $request['unit_name2'];
        $item->unit_qty2 = $request['unit_qty2'];
        $item->unit_name3 = $request['unit_name3'];
        $item->unit_qty3 = $request['unit_qty3'];
        $item->save();

        return new ItemResource($item);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return new ItemResource($item);
    }

    public function restore($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $item->restore();

        return new ItemResource($item);
    }
}
