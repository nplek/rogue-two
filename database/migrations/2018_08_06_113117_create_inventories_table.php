<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('itemcode',20);
            $table->string('name',100)->nullable();
            $table->string('dscription',100)->nullable();
            $table->unsignedInteger('item_id')->nullable();
            $table->foreign('item_id')
                ->references('id')
                ->on('items');
            //$table->string('project_code',20)->nullable();
            //$table->unsignedInteger('project_id')->nullable();
            /*$table->foreign('project_id')
                ->references('id')
                ->on('projects');*/
            $table->string('whs_code',20);
            $table->unsignedInteger('warehouse_id')->nullable();
            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses');
            $table->string('unit_name',16);
            $table->unsignedInteger('unit_id')->nullable();
            $table->foreign('unit_id')
                ->references('id')
                ->on('units');
            $table->double('remain_qty',19,6);  //
            $table->double('total_qty',19,6);
            $table->double('last_qty',19,6);
            $table->double('total_price',19,6);
            $table->double('last_price',19,6);
            //$table->double('fifo_price',19,6);
            //$table->double('average_price',19,6);
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
        Schema::dropIfExists('inventories');
    }
}
