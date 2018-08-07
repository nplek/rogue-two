<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('docnum',16);
            $table->string('doctype',1);    //P=Goods receiptPO,G=Goods receipt,I=Goods Issue,R=Goods Return
            $table->string('docstatus',1);
            $table->string('cardcode',15);
            $table->string('cardname',100);
            $table->date('docdate');
            $table->date('shipdate');
            $table->string('ref1',20);      //reference po
            $table->string('ref2',20);      //reference
            $table->string('project',20);   //project code
            $table->string('whscode',8);   //warehouse code
            $table->double('total_price',19,6);
            $table->string('quotation',30);
            $table->string('printed',1);
            $table->unsignedInteger('userid');          //user transaction
            $table->string('username',50);
            $table->string('gtoemp_id',20); //employee id (Goods issue)
            $table->string('gtoemp_name',50);   //employee name(Goods issue)
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_receipts');
    }
}
