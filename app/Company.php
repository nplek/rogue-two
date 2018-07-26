<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\HasActivity;
use App\Department;

class Company extends Model
{
    //use LogsActivity;
    use HasActivity;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected static $logAttributes = ['name', 'short_name'];
    protected static $logName = 'system';

    protected $fillable = [
        'name', 'short_name'
    ];

    public function departments(){
        return $this->hasMany(Department::class);
    }
}
