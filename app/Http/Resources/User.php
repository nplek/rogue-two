<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Role as RoleResource;
use App\Http\Resources\Location as LocationResource;
use App\Http\Resources\Position as PositionResource;
class User extends JsonResource
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
        //dd($this);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'location_id' => $this->location_id,
            'active' => $this->active,
            'last_login_at' => $this->last_login_at,
            'last_login_ip' => $this->last_login_ip,
            'last_logout_at' => $this->last_logout_at,
            'employee_id' => $this->employee_id,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'deleted_at' => $this->deleted_at,
            'roles'  => RoleResource::collection($this->roles),
            'location'  => new LocationResource($this->location),
            //'departments' => DepartmentResource::collection($this->department),
            'positions' => PositionResource::collection($this->positions),
            'manager_id' => $this->manager_id,
        ];
    }
}
