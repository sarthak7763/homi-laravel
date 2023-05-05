<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bidder_id');
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('bid_price');
            $table->string('bid_status')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('delete_status')->default(0);
            $table->timestamps();
        });

        Schema::table('bids', function(Blueprint $table) {
            $table->foreign('bidder_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')->onUpdate("cascade");

             $table->foreign('offer_id')
            ->references('id')
            ->on('property_offers')
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
        Schema::dropIfExists('bids');
    }
}
