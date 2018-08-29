<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Item;
use App\Unit;

class UOM extends Model
{
    protected $table = 'item_has_units';
    //protected $primaryKey = ['unit_id', 'item_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
