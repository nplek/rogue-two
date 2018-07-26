<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_num',25);
            $table->string('action_name',50);
            $table->string('description',100);
            $table->unsignedInteger('doc_id');
            $table->unsignedInteger('user_id');
                $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->string('username',100);
            $table->string('ip',50);
            $table->string('agent',200)->nullable();
            $table->string('state');
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
        Schema::dropIfExists('doc_activities');
    }
}
