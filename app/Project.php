<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['name', 'short_name','project_code','budget','active'];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'short_name','project_code','active'
    ];
    
    protected $full_name=null;
    //protected $attributes = ['full_name'];

    public function getFullNameAttribute(){
        return "{$this->project_code} {$this->name}";
    }

    public function scopeActive($query)
    {
        return $query->where('active', 'A');
    }
}
