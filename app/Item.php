<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Unit;

class Item extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['item_code','name','description','price','average_price'];

    public function mainunit()
    {
        return $this->hasOne(Unit::class,'id','unit_id');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class,'item_has_units',
        'item_id','unit_id');
        //return $this->belongsToMany(UOM::class);
    }
}
