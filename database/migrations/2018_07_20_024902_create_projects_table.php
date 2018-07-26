<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('project_code',20)->unique();
            $table->string('name',50);
            $table->string('short_name',8);
            $table->double('budget',16,2)->default(0);
            $table->double('book_budget',16,2)->default(0);
            $table->double('available_budget',16,2)->default(0);
            $table->double('used_budget',16,2)->default(0);
            $table->date('start_date');
            $table->date('end_date');
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
        Schema::dropIfExists('projects');
    }
}
