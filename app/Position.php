<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Position extends Model
{
    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'short_name','parent_id'
    ];

    public function parent(){
        return $this->belongsTo(Position::class);
    }
}
