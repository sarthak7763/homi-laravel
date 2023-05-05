<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntrestedCitiesTable extends Migration
{
    public function up()
    {
        Schema::create('intrested_cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('delete_status')->default(0);
            $table->timestamps();
        });


         Schema::table('intrested_cities', function(Blueprint $table) {
            $table->foreign('user_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')->onUpdate("cascade");

             $table->foreign('city_id')
            ->references('id')
            ->on('cities')
            ->onDelete('cascade')->onUpdate("cascade");
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('intrested_cities');
    }
}
