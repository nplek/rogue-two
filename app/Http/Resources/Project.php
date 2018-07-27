<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Project extends JsonResource
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
            'project_code' => $this->project_code,
            'name' => $this->name,
            'short_name' => $this->short_name,
            'budget' => $this->budget,
            'book_budget' => $this->book_budget,
            'available_budget' => $this->available_budget,
            'used_budget' => $this->used_budget,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'active' => $this->active,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
