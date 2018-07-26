<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();

            $table->string('active',1)->default('I'); //A=Active, I=Inactive, L=Lock
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip',40)->nullable();
            $table->timestamp('last_logout_at')->nullable();
            $table->string('first_name',100)->nullable();
            $table->string('last_name',100)->nullable();
            $table->string('employee_id',10)->default("000000");
            $table->string('mobile',30)->nullable();
            $table->string('phone',30)->nullable();
            $table->string('photo')->nullable();
            
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
        Schema::dropIfExists('users');
    }
}
