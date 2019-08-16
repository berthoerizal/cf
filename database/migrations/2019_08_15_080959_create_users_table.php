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
        // users {id, position_id(boleh null), username, password, api_token, user_fullname, user_email, user_phone_number, user_ktp, user_photo_ktp, user_photo}
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('position_id')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->text('api_token')->nullable();
            $table->string('user_fullname');
            $table->string('user_email');
            $table->string('user_phone_number');
            $table->string('user_ktp');
            $table->string('user_photo_ktp');
            $table->string('user_photo')->nullable();
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
