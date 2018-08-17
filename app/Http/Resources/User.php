<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
//use App\Http\Resources\Role as RoleResource;
//use App\Http\Resources\UserRole as UserRoleResource;
//use App\Http\Resources\Location as LocationResource;
//use App\Http\Resources\Position as PositionResource;
use App\Http\Resources\RoleUser as RoleUserResource;
use App\Http\Resources\Employee as EmployeeResource;
//use App\Http\Resources\Team as TeamResource;
//use App\Http\Resources\UserList;
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
            'employee_id' => $this->employee_id,
            'employee' => new EmployeeResource($this->employee),
            'active' => $this->active,
            'userroles' => RoleUserResource::collection($this->roleusers),
            'last_login_ip' => $this->last_login_ip,
            'last_login_at' => $this->last_login_at,
            'last_logout_at' => $this->last_logout_at,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            /*'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'location_id' => $this->location_id,
            'employee_id' => $this->employee_id,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'photo' => $this->photo,
            'userroles' => RoleUserResource::collection($this->roleusers),
            'location'  => new LocationResource($this->location),
            'positions' => PositionResource::collection($this->positions),
            'manager_id' => $this->manager_id,
            'manager' => new UserList($this->manager),*/
        ];
    }
}
