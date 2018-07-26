<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_request_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('doc_num',25)->unique();
            $table->year('doc_year');
            $table->date('doc_date');
            $table->string('title');
            $table->date('require_date');

            $table->unsignedInteger('company_id')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies');
            $table->unsignedInteger('project_id')->nullable();
            $table->foreign('project_id')
                ->references('id')
                ->on('projects');
            $table->unsignedInteger('owner_id')->nullable();
            $table->foreign('owner_id')
                ->references('id')
                ->on('users');
            $table->unsignedInteger('position_id')->nullable();
            $table->foreign('position_id')
                ->references('id')
                ->on('positions');
            $table->string('current_state')->default('darft');

            //
            $table->string('deliver_to',50)->nullable();
            $table->string('owner_firstname',100);
            $table->string('owner_lastname',100);
            $table->string('staff_id',10);
            $table->string('department_name',30);
            $table->string('position_name',50);

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
        Schema::dropIfExists('purchase_request_forms');
    }
}
