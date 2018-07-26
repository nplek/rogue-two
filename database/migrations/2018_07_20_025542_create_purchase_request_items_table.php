<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_num',25);
            $table->string('account_code',36)->nullable();
            $table->string('cost_id',36)->nullable();
            /*$table->unsignedInteger('cost_id')->nullable();
            $table->foreign('cost_id')
                ->references('id')
                ->on('cost_centers');*/
            /*$table->unsignedInteger('item_id');
            $table->foreign('item_id')
                ->references('id')
                ->on('items');*/
            $table->unsignedInteger('pr_id');
            $table->foreign('pr_id')
                ->references('id')
                ->on('purchase_request_forms')
                ->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->string('description',150);
            $table->string('purpose',150);
            $table->double('amount',16,2);
            $table->string('unit',10);
            $table->double('budget',16,2);
            $table->double('total_budget',16,2);
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
        Schema::dropIfExists('purchase_request_items');
    }
}
