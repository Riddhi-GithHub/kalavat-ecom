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
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('otp')->default('0')->comment('0:No OTP Verify,1:Yes OTP Verify')->nullable();
            $table->string('otp_verify')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('is_admin')->default('0')->comment('1=Super Admin,2=Admin')->nullable();
            $table->integer('is_delete')->default('0')->comment('0:No Delete, 1:Yes Delete')->nullable();
            $table->string('ststus')->nullable();
            $table->rememberToken();
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
