<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Warehouse;
use App\Project;
use App\GoodsReceiptItem;

class GoodsReceipt extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['docnum',
    'doctype','docstatus','cardcode','cardname',
    'docdate','shipdate','ref1','ref2','project',
    'whscode','total_price','quotation','userid',
    'username','gtoemp_id','gtoemp_name'];

    public function warehouse()
    {
        return $this->hasOne(Warehouse::class,'id','warehouse_id');
    }

    public function project()
    {
        return $this->hasOne(Project::class,'id','project_id');
    }

    public function items()
    {
        return $this->hasMany(GoodsReceiptItem::class,'doc_id','id');
    }
}
