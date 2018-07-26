<?php

namespace App;

use Laratrust\Models\LaratrustRole;
use App\Permission;

class Role extends LaratrustRole
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
