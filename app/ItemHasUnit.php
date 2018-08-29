<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ItemHasUnit extends Model
{
    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = [
        'item_id', 
        'unit_id',
        'main_qty',
    ];

    protected $fillable = [
        'item_id', 'unit_id','main_qty'
    ];

}
