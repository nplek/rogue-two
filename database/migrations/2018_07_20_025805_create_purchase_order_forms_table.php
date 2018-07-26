<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseOrderFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_forms', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->primary('id');
            $table->integer('docnum');
            $table->string('doctype',1);
            $table->string('canceled',1);
            $table->string('printed',1);
            $table->string('docstatus',1);
            $table->dateTime('docdate');
            $table->dateTime('docduedate');
            $table->dateTime('taxdate');
            $table->string('cardcode',15);
            $table->string('cardName',100)->nullable();
            $table->string('address',254)->nullable();
            $table->string('numAtCard',100)->nullable();
            $table->string('ref1',11);
            $table->string('ref2',11)->nullable();
            $table->string('comments',254)->nullable();
            $table->string('confirmed',1)->nullable();
            $table->string('project',20);
            $table->double('DocTotal',19,6);
            $table->double('DocTotalSy',19,6);
            $table->dateTime('updateDate');
            $table->dateTime('createDate');
            $table->integer('series');
            $table->string('verifyBy',30)->nullable();
            $table->string('approved',30)->nullable();
            $table->string('pr_no',20)->nullable();
            $table->string('quotation',20)->nullable();
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
        Schema::dropIfExists('purchase_order_forms');
    }
}
