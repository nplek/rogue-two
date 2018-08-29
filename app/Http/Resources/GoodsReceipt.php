<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Warehouse as WarehouseResource;
use App\Http\Resources\Project as ProjectResource;

class GoodsReceipt extends JsonResource
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
            'id' => $this->id,
            'docnum' => $this->docnum,
            'doctype' => $this->doctype,
            'docstatus' => $this->docstatus,
            'gtoemp_id' => $this->gtoemp_id,
            'gtoemp_name' => $this->gtoemp_name,
            'cardcode' => $this->cardcode,
            'cardname' => $this->cardname,
            'total_price' => $this->total_price,
            'ref1' => $this->ref1,
            'ref2' => $this->ref2,
            'ref3' => $this->ref3,
            'docdate' => $this->docdate,
            'shipdate' => $this->shipdate,
            'project_code'=> $this->project_code,
            'project' => new ProjectResource($this->project),
            'whs_code' => $this->whs_code,
            'warehouse' => new WarehouseResource($this->warehouse),
            'deleted_at' => $this->deleted_at,
            'items' => GoodsReceiptItem::collection($this->items),
        ];
    }
}
