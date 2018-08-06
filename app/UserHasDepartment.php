<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class UserHasDepartment extends Model
{
    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'department_id', 
        'user_id',
    ];

    protected $fillable = [
        'department_id', 'user_id'
    ];
}
