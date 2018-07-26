<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class PurchaseOrderForm extends Model
{
    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;

    protected $fillable = [
        'id',
        'docnum', 'doctype', 'canceled', 'printed',
        'docstatus','docduedate','taxdate','cardcode',
        'cardName','address','numAtCard','ref1',
        'ref2','comments','confirmed','project',
        'DocTotal','DocTotalSy','updateDate','createDate',
        'series','verifyBy','approved','quotation'
    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class,'DocEntry','id');
    }
}
