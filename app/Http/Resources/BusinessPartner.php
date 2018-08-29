<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessPartner extends JsonResource
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
            'card_code' => $this->card_code,
            'card_name' => $this->card_name,
            'card_type' => $this->card_type,
            'groupcode' => $this->groupcode,
            'lictradnum' => $this->lictradnum,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
