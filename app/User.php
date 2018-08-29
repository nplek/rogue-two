<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
//use App\Location;
//use App\Position;
use App\Employee;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens;
    use LogsActivity;
    use LaratrustUserTrait;
    use Notifiable;
    
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;

    protected static $logAttributes = [
        'name', 
        'email',
        'active',
        'password',
    ];

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','active'
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

    /*protected $employee_detail = null;

    public function getEmployeeDetailAttribute(){
        return "{$this->employee_id} {$this->first_name} {$this->last_name}";
    }*/

    /*public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function positions()
    {
        return $this->belongsToMany(Position::class,'user_has_positions',
        'user_id','position_id')->withTimestamps();
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class,'user_has_departments',
        'user_id','department_id')->withTimestamps();
    }*/

    public function roleusers()
    {
        return $this->hasmany(RoleUser::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class,'id','employee_id');
    }
}
