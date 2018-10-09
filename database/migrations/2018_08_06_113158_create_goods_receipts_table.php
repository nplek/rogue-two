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
            $table->string('docnum',25);
            $table->unsignedInteger('docentry')->nullable();
            $table->string('doctype',1)
            ->comment('P=Goods receiptPO,G=Goods receipt,I=Goods Issue,R=Goods Return,S=Return items,T=Transfer,A=Adjust');    //P=Goods receiptPO,G=Goods receipt,I=Goods Issue,R=Goods Return,T=Transfer,A=Adjust
            $table->string('docstatus',1);
            $table->string('cardcode',15)->nullable();
            $table->string('cardname',100)->nullable();
            $table->string('address',200)->nullable();
            $table->date('docdate');
            $table->date('shipdate');
            $table->string('remark',200)->nullable()
                ->comment('Remark');      //reference other
            $table->string('ref1',20)->nullable()
                ->comment('PO Number');      //reference po
            $table->string('ref2',20)->nullable()
                ->comment('GR Number');      //reference เลขที่ใบส่งของ
            $table->string('ref3',100)->nullable()
                ->comment('Other reference');      //reference other
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
            $table->double('total_price',19,6);
            $table->string('quotation',30)->nullable();
            $table->string('printed',1);
            $table->unsignedInteger('userid')
            ->comment('user id');          //user transaction
            $table->string('username',50)
            ->comment('user name');
            $table->string('gtoemp_id',20)
            ->comment('employee id'); //employee id (Goods issue)
            $table->string('gtoemp_name',50)
            ->comment('employee name');   //employee name(Goods issue)
            $table->string('pr_no',30)->nullable();
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
