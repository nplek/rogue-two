<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_code',20)->unique();
            $table->string('name',50);
            $table->string('description')->nullable();
            $table->unsignedInteger('item_group_id')->nullable();
            $table->foreign('item_group_id')
                ->references('id')
                ->on('item_groups');
            $table->double('price',8,2)->default(0);
            $table->double('average_price',8,2)->default(0);
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
        Schema::dropIfExists('items');
    }
}
