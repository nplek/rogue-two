<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Location;
use App\Position;

class User extends Authenticatable
{
    use LogsActivity;
    use LaratrustUserTrait;
    use Notifiable;
    
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;

    protected static $logAttributes = [
        'name', 
        'email',
        'active', 
        'last_login_at', 
        'last_login_ip',
        'last_logout_at',
        'first_name',
        'last_name',
        'employee_id',
        'location_id'
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','first_name','last_name','employee_id','location_id','active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function setPasswordAttribute($password)
    {   
        $this->attributes['password'] = Hash::make($password);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 'A');
    }

    protected $employee_detail = null;

    public function getEmployeeDetailAttribute(){
        return "{$this->employee_id} {$this->first_name} {$this->last_name}";
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class,'user_has_positions',
        'user_id','position_id')->withTimestamps();
    }
}
