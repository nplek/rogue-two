<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PurchaseItem as PurchaseItemResource;

class PurchaseOrder extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->DocEntry,
            'docnum' => $this->DocNum,
            'doctype' => $this->DocType,
            'canceled' => $this->CANCELED,
            'printed' => $this->Printed,
            'docstatus' => $this->DocStatus,
            'docdate' => $this->DocDate,
            'docduedate' => $this->DocDueDate,
            'taxdate' => $this->TaxDate,
            'cardcode' => $this->CardCode,
            'cardName' => $this->CardName,
            'address' => $this->Address,
            'numAtCard' => $this->NumAtCard,
            'ref1' => $this->Ref1,
            'ref2' => $this->Ref2,
            'comments' => $this->Comments,
            'confirmed' => $this->Confirmed,
            'project' => $this->Project,
            'DocTotal' => $this->DocTotal,
            'DocTotalSy' => $this->DocTotalSy,
            'updateDate' => $this->UpdateDate,
            'createDate' => $this->CreateDate,
            'series' => $this->Series,
            'verifyBy' => $this->U_NEC_VERIFY,
            'approved' => $this->U_NEC_Approved,
            'pr_no' => $this->U_NEC_PR_NO,
            'quotation' => $this->U_NEC_Quotation,
            
            'items' => PurchaseItemResource::collection($this->purchaseitems)
        ];
    }
}
