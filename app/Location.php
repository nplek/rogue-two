<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Location extends Model
{
    use LogsActivity;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'short_name'];

    protected $fillable = [
        'name', 'short_name'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
