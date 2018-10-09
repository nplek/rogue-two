<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderList extends JsonResource
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
            /*'docstatus' => $this->DocStatus,
            'docdate' => $this->DocDate,
            'docduedate' => $this->DocDueDate,
            'cardcode' => $this->CardCode,
            'cardName' => $this->CardName,
            'updateDate' => $this->UpdateDate,
            'createDate' => $this->CreateDate,
            'pr_no' => $this->U_NEC_PR_NO,
            'quotation' => $this->U_NEC_Quotation,*/
        ];
    }
}
