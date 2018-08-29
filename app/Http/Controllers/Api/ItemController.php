<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use App\UOM;
use App\Unit;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\Item as ItemResource;
use App\Http\Resources\UOMResource;
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
        return ItemResource::collection(Item::get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'item_code'=>'required|max:20|min:3|unique:items',
            'name'=>'required|min:3|max:50',
            'main_unit'=>'required',
            'unit_id'=>'required',
        ]);

        $item = new Item();
        $item->item_code = $request['item_code'];
        $item->name = $request['name'];
        $item->description = $request['description'];
        $item->main_unit = $request['main_unit'];
        $item->unit_id = $request['unit_id'];
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
            'main_unit'=>'required',
            'unit_id'=>'required',
        ]);
        $item = Item::findOrFail($id);
        $item->name = $request['name'];
        $item->description = $request['description'];
        $item->main_unit = $request['main_unit'];
        $item->unit_id = $request['unit_id'];
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

    public function listUOM($id){
        return UOMResource::collection(UOM::where('item_id','=',$id)->get());
    }

    public function showUOM($id, $uid){
        return new UOMResource(UOM::where('item_id','=',$id)->where('unit_id','=',$uid)->first());
    }

    public function storeUOM(Request $request, $id){
        $this->validate($request, [
            'unit_id' => 'required',
            'main_qty' => 'required',
        ]);
        
        $unit_id = $request['unit_id'];
        $unit = Unit::findOrFail($unit_id);
        $item = Item::findOrFail($id);
        $uom = new UOM();
        $uom->unit_id = $unit_id;
        $uom->item_id = $id;
        $uom->main_qty = $request['main_qty'];
        $uom->save();
        
        return new UOMResource($uom);
    }

    public function destroyUOM(Request $request, $id,$uid){
        $item = Item::findOrFail($id);
        $unit = Unit::findOrFail($uid);
        $uom = UOM::where('item_id','=', $item->id)->where('unit_id','=',$unit->id)->first();
        //dd($uom);
        //$uom->delete();
        $item->units()->detach($unit);

        return new UOMResource($uom);
    }


}
