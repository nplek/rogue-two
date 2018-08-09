<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EmployeeList;
use App\Http\Resources\Location as LocationResource;
use App\Http\Resources\Position as PositionResource;
class Employee extends JsonResource
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
            'employee_id' => $this->employee_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'location_id' => $this->location_id,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'location'  => new LocationResource($this->location),
            'positions' => PositionResource::collection($this->positions),
            'manager_id' => $this->manager_id,
            'manager' => new EmployeeList($this->manager),
            'type' => $this->type,
            'active' => $this->active,
        ];
    }
}
