<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyOffersTable extends Migration
{
    
    public function up()
    {
        Schema::create('property_offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('date_start');
            $table->string('date_end');
            $table->string('time_start');
            $table->string('time_end');
            $table->unsignedBigInteger('add_by');
            $table->longText('offer_details')->nullable();
            $table->tinyInteger('sale_status')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('delete_status')->default(0);
            $table->timestamps();
        });

        Schema::table('property_offers', function(Blueprint $table) {
            $table->foreign('add_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')->onUpdate("cascade");

            $table->foreign('property_id')
            ->references('id')
            ->on('properties')
            ->onDelete('cascade')->onUpdate("cascade");
        });
    }

    public function down()
    {
        Schema::dropIfExists('property_offers');
    }
}
