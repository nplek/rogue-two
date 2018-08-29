<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessPartner;
use App\Http\Resources\BusinessPartnerCollection;
use App\Http\Resources\BusinessPartner as BusinessPartnerResource;
use App\Http\Resources\BusinessPartnerList;
use Auth;

class BusinessPartnerController extends Controller
{
    public function __construct() {
    }

    public function index()
    {
        if (Auth::user()->can('restore-bps') ){
            return new BusinessPartnerCollection(BusinessPartner::withTrashed()->paginate(50));
        } else {
            return new BusinessPartnerCollection(BusinessPartner::paginate(50));
        }
    }

    public function list()
    {
        return BusinessPartnerList::collection(BusinessPartner::get());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'cardcode'=>'required|max:20|min:3|unique:items',
            'cardname'=>'required|min:3|max:100',
        ]);

        $bp = new BusinessPartner();
        $bp->cardcode = $request['cardcode'];
        $bp->cardname = $request['cardname'];
        $bp->cardtype = $request['cardtype'];
        $bp->save();

        return new BusinessPartnerResource($bp);
    }

    public function show($id)
    {
        return new ItemResource(Item::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'cardname'=>'required|min:3|max:100',
        ]);
        $bp = BusinessPartner::findOrFail($id);
        $bp->cardcode = $request['cardcode'];
        $bp->cardname = $request['cardname'];
        $bp->cardtype = $request['cardtype'];
        $bp->save();

        return new BusinessPartnerResource($bp);
    }

    public function destroy($id)
    {
        $bp = BusinessPartner::findOrFail($id);
        $bp->delete();
        return new BusinessPartnerResource($bp);
    }

    public function restore($id)
    {
        $bp = BusinessPartner::onlyTrashed()->findOrFail($id);
        $bp->restore();

        return new BusinessPartnerResource($bp);
    }
}
