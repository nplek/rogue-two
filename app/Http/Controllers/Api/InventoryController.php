<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Inventory;
use App\ItemGroup;
use App\Item;
use App\Http\Resources\InventoryCollection;
use App\Http\Resources\Inventory as InventoryResource;
use App\Http\Resources\InventoryList;
use Auth;
class InventoryController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        if (Auth::user()->can('restore-inventory') ){
            return new InventoryCollection(Inventory::withTrashed()->paginate(50));
        } else {
            return new InventoryCollection(Inventory::paginate(50));
        }
    }

    public function list()
    {
        return InventoryList::collection(Inventory::get());
    }

    public function show($id)
    {
        return new InventoryResource(Inventory::findOrFail($id));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'itemcode' => 'required|max:20',
            'dscription' => 'required|max:100',
            'project'=>'required|max:20',
            'unit' => 'required|max:16',
        ]);

        $inventory = new Inventory();

        $inventory->itemcode = $request['itemcode'];
        $inventory->dscription = $request['dscription'];
        $inventory->project = $request['project'];
        $inventory->project_id = $request['project_id'];
        $inventory->save();


        return new InventoryResource($inventory);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'itemcode' => 'required|max:20',
            'dscription' => 'required|max:100',
            'project'=>'required|max:20',
            'unit' => 'required|max:16',
        ]);
        $inventory = Inventory::findOrFail($id);
        
        $Inventory->save();
        return new InventoryResource($inventory);

    }
}
