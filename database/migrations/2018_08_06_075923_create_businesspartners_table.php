<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinesspartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_partners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_code',20)->unique();
            $table->string('card_name',100);
            $table->string('card_type',1);   //C=Customer, S=supplier
            $table->integer('series')->nullable();
            $table->integer('groupcode')->nullable();
            $table->string('lictradnum',50)->nullable();
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
        Schema::dropIfExists('business_partners');
    }
}
