<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class UserHasPosition extends Model
{
    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'position_id', 
        'user_id',
    ];

    protected $fillable = [
        'position_id', 'user_id'
    ];
}
