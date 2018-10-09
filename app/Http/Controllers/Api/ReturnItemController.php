<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GoodsReceipt;
use App\GoodsReceiptItem;
use App\Item;
use App\UOM;
use App\Inventory;
use App\Http\Resources\GoodsReceiptCollection;
use App\Http\Resources\GoodsReceipt as GoodsReceiptResource;
use App\Http\Resources\GoodsReceiptList;
use App\Http\Resources\GoodsReceiptItemCollection;
use Auth;

class ReturnItemController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        if (Auth::user()->can('restore-goodsreceipt') ){
            return new GoodsReceiptCollection(GoodsReceipt::withTrashed()->paginate(50));
        } else {
            return new GoodsReceiptCollection(GoodsReceipt::paginate(50));
        }
    }

    public function findItemByWhs($item_id,$whs_id)
    {
        return new GoodsReceiptItemCollection(GoodsReceiptItem::where('item_id','=',$item_id)->where('warehouse_id','=',$whs_id)->paginate(50));
    }

    public function list()
    {
        return GoodsReceiptResource::collection(GoodsReceipt::get());
    }

    

    public function dummyDoc(){
        $department = auth()->user()->employee->department->short_name;
        $dummy = \GenDocNumber::dummyDocnumber(env('DOC_RIM', 'RIM-NUM'), $department);
        $success['docnum'] =  $dummy;
        return response()->json(['data' => $success], 200); 
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'docdate' => 'required',
            'shipdate' => 'required',
            'whs_code' => 'required',
            'transactions' => 'required'
        ]);
        $u = auth()->user();
        $e = auth()->user()->employee;
        $department = auth()->user()->employee->department->short_name;
        try {

            \DB::beginTransaction();
            $goodsreceipt = new GoodsReceipt();
            $goodsreceipt->docstatus = 'A';
            $goodsreceipt->doctype='S';
            $goodsreceipt->cardcode="";
            $goodsreceipt->cardname = "RETURN";
            $goodsreceipt->docdate = date("Y-m-d", strtotime($request['docdate']));
            $goodsreceipt->shipdate = date("Y-m-d", strtotime($request['shipdate']));
            $goodsreceipt->remark = $request['remark'];
            $goodsreceipt->ref1 = '';//$request['ref1'];
            $goodsreceipt->ref2 = $request['ref2'];
            $goodsreceipt->warehouse_id = $request['whs_id'];
            $goodsreceipt->whs_code = $request['whs_code'];

            //$goodsreceipt->total_price=$request['total_price'];
            $goodsreceipt->total_price=1;
            $goodsreceipt->quotation='';
            $goodsreceipt->printed='N';
            $goodsreceipt->userid=$u->id;;
            $goodsreceipt->username=$u->name;
            $goodsreceipt->gtoemp_id = $e->employee_id;
            $goodsreceipt->gtoemp_name = $e->first_name . ' ' . $e->last_name;

            $goodsreceipt->docnum = \GenDocNumber::genDocnumber(env('DOC_RIM', 'RIM-NUM'), $department);
            $goodsreceipt->save();

            $trans = $request['transactions'];
            if (isset($trans)) {
                foreach ($trans as $value) {
                    $item_id = $value['item_id'];
                    $unit_id = $value['unit_id'];
                    $item = Item::findOrFail($item_id);
                    $uom = UOM::where('item_id','=',$item_id)->where('unit_id','=',$unit_id)->first();
                    $gitem = new GoodsReceiptItem();
                    $gitem->doctype='S';
                    $gitem->doc_id = $goodsreceipt->id;
                    $gitem->docnum = $goodsreceipt->docnum;
                    $gitem->warehouse_id = $goodsreceipt->warehouse_id;
                    $gitem->whs_code = $goodsreceipt->whs_code;
                    $gitem->docdate = $goodsreceipt->docdate;
                    $gitem->shipdate = $goodsreceipt->shipdate;
                    $gitem->itemcode = $value['item_code'];
                    $gitem->item_id = $item_id;
                    $gitem->dscription = $value['dscription'];

                    $gitem->unit = $value['unit'];
                    $qty = $value['qty'];
                    $gitem->qty = $qty;
                    $gitem->factor_qty = $qty * $uom->main_qty;
                    //$price = $value['price'];
                    //$gitem->unit_price =$price;
                    //$gitem->total_price = $value['total_price'];
                    $gitem->unit_price =1;
                    $gitem->total_price =1;
                    $gitem->status = 'I';
                    $gitem->save();
                    $inv = Inventory::where('item_id', '=', $item_id)->where('warehouse_id','=',$gitem->warehouse_id)->first();
                    if ($inv !=null ){
                        $inv->remain_qty = ( $qty * $uom->main_qty) + $inv->remain_qty;
                        $inv->total_qty =  ($qty * $uom->main_qty) + $inv->total_qty;
                        $inv->last_qty = $qty * $uom->main_qty;
                        //$inv->total_price = $inv->total_price + $gitem->total_price;
                        $inv->save();
                        //$gitem->status = 'I';
                        //$gitem->save();
                    } else {
                        $inv = new Inventory();
                        $inv->itemcode = $item->item_code;
                        $inv->item_id = $item->id;
                        $inv->name = $item->name;
                        $inv->dscription = $item->description;
                        $inv->whs_code = $gitem->whs_code;
                        $inv->warehouse_id = $gitem->warehouse_id;

                        $inv->unit_name = $item->main_unit;
                        $inv->unit_id = $item->unit_id;

                        $inv->remain_qty = $qty * $uom->main_qty;
                        $inv->total_qty = $qty * $uom->main_qty;
                        $inv->last_qty = $qty * $uom->main_qty;

                        //$inv->total_price = $gitem->total_price;
                        //$inv->last_price = $gitem->total_price;
                        $inv->save();

                        //$gitem->status = 'I';
                        //$gitem->save();
                    }
                }
            }
            \DB::commit();
        } catch (Exception $e){
            DB::rollback();
            throw $e;
            
        }
        
        return new GoodsReceiptResource($goodsreceipt);
    }

    public function show($id)
    {
        return new GoodsReceiptResource(GoodsReceipt::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'=>'required|min:3|max:50',
        ]);
        $goodsreceipt = GoodsReceipt::findOrFail($id);
        //$goodsreceipt->save();

        return new GoodsReceiptResource($GoodsReceipt);
    }
}
