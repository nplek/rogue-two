<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsReceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_receipt_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('doc_id');
            $table->foreign('doc_id')
                ->references('id')
                ->on('goods_receipts');
            $table->string('docnum',16);
            $table->string('itemcode',20);
            $table->string('dscription',100);
            $table->string('project',20);
            $table->string('unit',16);
            $table->double('open_qty',19,6);
            $table->double('qty',19,6);
            $table->double('remain_qty',19,6);  //for FIFO
            $table->double('price',19,6);
            $table->double('total_price',19,6);
            $table->date('shipdate');
            $table->date('docdate');
            
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
        Schema::dropIfExists('goods_receipt_items');
    }
}
