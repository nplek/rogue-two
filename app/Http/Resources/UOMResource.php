<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Item as ItemResource;
use App\Http\Resources\ItemUnit as UnitResource;

class UOMResource extends JsonResource
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
            'item' => new ItemResource($this->item),
            'unit' => new UnitResource($this->unit),
            'main_qty' => $this->main_qty,
        ];
    }
}
