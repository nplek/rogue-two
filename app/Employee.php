<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['first_name', 'last_name','phone','mobile','manager_id','location_id','active'];

    public function scopeManager($query)
    {
        return $query->where('type', 'M');
    }

    public function scopeStaff($query)
    {
        return $query->where('type', 'S');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 'A');
    }
    
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class,'employee_has_positions',
        'employee_id','position_id')->withTimestamps();
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class,'employee_has_departments',
        'employee_id','department_id')->withTimestamps();
    }
}
