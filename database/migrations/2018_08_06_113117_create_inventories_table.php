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
            $table->string('dscription',100);
            $table->string('project',20);
            $table->string('unit',16);
            $table->double('remain_qty',19,6);
            $table->double('total_qty',19,6);
            $table->double('last_qty',19,6);
            $table->double('total_price',19,6);
            $table->double('last_price',19,6);
            $table->double('fifo_price',19,6);
            $table->double('average_price',19,6);
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
