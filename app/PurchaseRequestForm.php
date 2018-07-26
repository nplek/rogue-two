<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class PurchaseRequestForm extends Model
{
    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;

    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'doc_num', 'title'
    ];

    public function purchase_items()
    {
        return $this->belongsToMany(PurchaseRequestItem::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }
}
