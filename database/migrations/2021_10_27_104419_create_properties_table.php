<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id(); 
            $table->string('property_code')->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->unsignedBigInteger('add_by');
            $table->unsignedBigInteger('property_type')->nullable();
            $table->string('image')->nullable();
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('country')->nullable();
            $table->unsignedBigInteger('state')->nullable();
            $table->unsignedBigInteger('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('property_size')->nullable();
            $table->float('base_price',10, 2)->nullable();
            $table->float('price_from',10, 2)->nullable();
            $table->float('price_to',10, 2)->nullable();
            $table->string('currency_type')->nullable();
            $table->string('year_from')->nullable();
            $table->string('year_to')->nullable();
            $table->string('no_of_bathroom')->nullable();
            $table->string('no_of_bedroom')->nullable();
            $table->string('no_of_roof')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('delete_status')->default(0);
           
            $table->timestamps();
        });

         Schema::table('properties', function(Blueprint $table) {
            
            $table->foreign('add_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')->onUpdate("cascade");

              $table->foreign('property_type')
            ->references('id')
            ->on('property_types')
            ->onDelete('cascade')->onUpdate("cascade");



             $table->foreign('country')
            ->references('id')
            ->on('countries')
            ->onDelete('cascade')->onUpdate("cascade");

             $table->foreign('state')
            ->references('id')
            ->on('states')
            ->onDelete('cascade')->onUpdate("cascade");

             $table->foreign('city')
            ->references('id')
            ->on('cities')
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
        Schema::dropIfExists('properties');
    }
}
