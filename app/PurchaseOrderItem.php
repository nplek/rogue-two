<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PurchaseOrderItem extends Model
{
    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;
    
    public $incrementing = false;
}
