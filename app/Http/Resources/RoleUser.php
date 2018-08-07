<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleUser extends JsonResource
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
            'user_id' => $this->user_id,
            'user' => $this->user,
            'role_id' => $this->role_id,
            'role' => $this->role,
            'team_id' => $this->team_id,
            'team' => $this->team,
        ];
    }
}
