<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fav_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('property_id');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('delete_status')->default(0);
            $table->timestamps();
        });

        Schema::table('fav_properties', function(Blueprint $table) {
            $table->foreign('buyer_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')->onUpdate("cascade");

            $table->foreign('property_id')
            ->references('id')
            ->on('properties')
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
        Schema::dropIfExists('fav_properties');
    }
}
