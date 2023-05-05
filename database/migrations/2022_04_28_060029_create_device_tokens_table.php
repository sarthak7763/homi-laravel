<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('device_id')->nullable();
            $table->string('device_token')->nullable();
            $table->enum('device_type',['Android','IOS'])->default("Android");
            $table->timestamps();
        });

          Schema::table('device_tokens', function(Blueprint $table) {
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_tokens');
    }
}
