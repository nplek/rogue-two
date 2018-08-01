<?php

namespace App;

use Laratrust\Models\LaratrustTeam;
use Spatie\Activitylog\Traits\LogsActivity;

class Team extends LaratrustTeam
{
    use LogsActivity;
    protected static $logName = 'security';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'name', 
        'display_name',
        'description',
    ];
}
