<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UOMResource;
use App\Http\Resources\ItemUnit as ItemUnitResource;

class Item extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'item_code' => $this->item_code,
            'name' => $this->name,
            'description' => $this->description,
            //'main_unit' => $this->main_unit,
            //'unit_id' => $this->unit_id,
            'mainunit' => new ItemUnitResource($this->mainunit),
            'deleted_at' => $this->deleted_at,
            'units' => ItemUnitResource::collection($this->units),
        ];
    }
}
