<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
     //keys POR1_PRIMARY
    //Primary key DocEntry, LineNum
    //Index
    protected $primaryKey = ['DocEntry', 'LineNum'];
    public $incrementing = false;
    protected $connection = 'kbuild';

    protected $table = 'POR1';
    public $timestamps = false;

    protected $visible = [
        'DocEntry', 'LineNum','LineStatus','ItemCode',
        'Dscription','Quantity','Price','TotalSumSy','WhsCode',
        'AcctCode','Project','ShipDate','InvntSttus',
        'VatGroup','PriceAfVAT','VolUnit','VatSum',
        'ObjType','unitMsr2','OcrCode','OcrCode2','OcrCode3'
    ];

    /*public function purchaseorder(){
        return $this->belongsTo(PurchaseOrder::class,'DocEntry','DocEntry');
    }*/
}
