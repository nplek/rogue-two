<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GoodsReceipt;
use App\GoodsReceiptItem;
use App\Item;
use App\UOM;
use App\Inventory;
use App\Http\Resources\GoodsIssueCollection;
use App\Http\Resources\GoodsIssue as GoodsIssueResource;
use App\Http\Resources\GoodsIssueItemCollection;
use App\Http\Resources\GoodsIssueItem as GoodsIssueItemResource;

class AdjustItemController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        //
    }

    public function findItemByWhs($item_id,$whs_id)
    {
        return new GoodsIssueItemCollection(GoodsIssueItem::where('item_id','=',$item_id)->where('warehouse_id','=',$whs_id)->paginate(50));
    }

    public function dummyDoc(){
        $department = auth()->user()->employee->department->short_name;
        $dummy = \GenDocNumber::dummyDocnumber(env('DOC_IAD', 'IAD-NUM'), $department);
        $success['docnum'] =  $dummy;
        return response()->json(['data' => $success], 200); 
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'docdate' => 'required',
            'issuedate' => 'required',
            'whs_code' => 'required',
            'transactions' => 'required'
        ]);
        $u = auth()->user();
        $e = auth()->user()->employee;
        $department = auth()->user()->employee->department->short_name;
        try {

            \DB::beginTransaction();
            $issue = new GoodsReceipt();
            $issue->docstatus = 'A';
            $issue->doctype='A';
            $issue->cardname='ADJUST';
            $issue->docdate = date("Y-m-d", strtotime($request['docdate']));
            $issue->shipdate = date("Y-m-d", strtotime($request['issuedate']));
            $issue->remark = $request['remark'];
            $issue->ref1 = '' ;//$request['ref1'];
            $issue->ref2 = $request['ref2'];
            $issue->ref3 = $request['ref3'];
            $issue->warehouse_id = $request['whs_id'];
            $issue->whs_code = $request['whs_code'];
            $issue->total_price= 0;
            $issue->quotation='';
            $issue->printed='N';
            $issue->userid=$u->id;;
            $issue->username=$u->name;
            $issue->gtoemp_id = $e->employee_id;
            $issue->gtoemp_name = $e->first_name . ' ' . $e->last_name;

            $issue->docnum = \GenDocNumber::genDocnumber(env('DOC_IAD', 'IAD-NUM'), $department);
            $issue->save();

            $trans = $request['transactions'];
            if (isset($trans)) {
                foreach ($trans as $value) {
                    $item_id = $value['item_id'];
                    $unit_id = $value['unit_id'];
                    $item = Item::findOrFail($item_id);
                    $uom = UOM::where('item_id','=',$item_id)->where('unit_id','=',$unit_id)->first();
                    $gitem = new GoodsReceiptItem();
                    $gitem->doctype='A';
                    $gitem->doc_id = $issue->id;
                    $gitem->docnum = $issue->docnum;
                    $gitem->warehouse_id = $issue->warehouse_id;
                    $gitem->whs_code = $issue->whs_code;
                    $gitem->docdate = $issue->docdate;
                    $gitem->shipdate = $issue->shipdate;
                    $gitem->itemcode = $value['item_code'];
                    $gitem->item_id = $item_id;
                    $gitem->dscription = $value['dscription'];

                    $gitem->unit = $value['unit'];
                    $qty = $value['qty'];
                    $gitem->qty = $qty;
                    $gitem->factor_qty = $qty * $uom->main_qty;
                    //$price = $value['price'];
                    $gitem->unit_price =0;
                    $gitem->total_price = 0;
                    $gitem->status = 'I';
                    $gitem->save();
                    $inv = Inventory::where('item_id', '=', $item_id)->where('warehouse_id','=',$gitem->warehouse_id)->first();
                    if ($inv !=null ){
                        $inv->remain_qty = $inv->remain_qty + ( $qty * $uom->main_qty);
                        $inv->save();
                    }
                }
            }
            \DB::commit();
        } catch (Exception $e){
            DB::rollback();
            throw $e;
        }
        
        return new GoodsIssueResource($issue);
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
}
