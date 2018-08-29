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
            $table->string('doctype',1)
            ->comment('P=Goods receiptPO,G=Goods receipt,I=Goods Issue,R=Goods Return,T=Transfer,A=Adjust');
            $table->string('itemcode',20);
            $table->unsignedInteger('item_id')->nullable();
            $table->foreign('item_id')
                ->references('id')
                ->on('items');
            $table->string('dscription',100);
            $table->string('project_code',20)->nullable();   //project code
            $table->unsignedInteger('project_id')->nullable();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');
            $table->string('whs_code',20);   //warehouse code
            $table->unsignedInteger('warehouse_id')->nullable();
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');
            $table->string('unit',16);
            $table->string('status',1)->default('N')
            ->comment('I=Update to inventory, N=Not update to inventory(error)');     //I=update to inventory, N=Not update to inventory(error)
            $table->double('qty',19,6);
            $table->double('factor_qty',19,6);
            $table->double('unit_price',19,6);
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
