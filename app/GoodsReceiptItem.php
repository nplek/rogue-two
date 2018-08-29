<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use App\GoodsReceipt;
class GoodsReceiptItem extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    use LogsActivity;
    protected static $logName = 'system';
    protected static $logOnlyDirty = true;
    protected static $logAttributes = ['docnum',
    'doc_id','itemcode','dscription','project',
    'unit','open_qty','qty','remain_qty','price',
    'total_price','shipdate','docdate'];

    public function goodsreceipt()
    {
        return $this->belongsTo(GoodsReceipt::class);
    }
}
