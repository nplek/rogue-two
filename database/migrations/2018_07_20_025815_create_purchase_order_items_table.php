<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('DocEntry');
            $table->foreign('DocEntry')
                ->references('id')
                ->on('purchase_order_forms')
                ->onDelete('cascade');
            $table->integer('LineNum');
            $table->string('LineStatus',1);
            $table->string('ItemCode',20);
            $table->string('Dscription',100)->nullable();
            $table->double('Quantity',19,6);
            $table->dateTime('ShipDate');
            $table->double('Price',19,6);
            $table->string('WhsCode',8);
            $table->string('AcctCode',15);
            $table->double('TotalSumSy',19,6);
            $table->string('InvntSttus',1);
            $table->string('OcrCode',8);
            $table->string('Project',20);
            $table->string('VatGroup',8)->nullable();
            $table->double('PriceAfVAT',19,6);
            $table->integer('VolUnit');
            $table->double('VatSum',19,6);
            $table->integer('ObjType');
            $table->string('OcrCode2',8)->nullable();
            $table->string('OcrCode3',8)->nullable();
            $table->string('unitMsr2',20)->nullable();
            $table->double('remainQuantity',19,6);
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
        Schema::dropIfExists('purchase_order_items');
    }
}
