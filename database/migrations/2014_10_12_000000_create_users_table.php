<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile_no')->unique()->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('home_address')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('delete_status')->default(0);
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
