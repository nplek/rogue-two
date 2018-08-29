<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Warehouse as WarehouseResource;

class Inventory extends JsonResource
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
            'itemcode' => $this->itemcode,
            'name' => $this->name,
            'dscription' => $this->dscription,
            'item_id' => $this->item_id,
            'warehouse' => new WarehouseResource($this->warehouse),
            'remain_qty' => $this->remain_qty,
            'unit_name' => $this->unit_name,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
