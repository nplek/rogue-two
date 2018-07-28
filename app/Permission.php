<?php

namespace App;

use Laratrust\Models\LaratrustPermission;
use Spatie\Activitylog\Traits\LogsActivity;

class Permission extends LaratrustPermission
{
    use LogsActivity;
    protected static $logName = 'security';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'name', 
        'display_name',
    ];
}
