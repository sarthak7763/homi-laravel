<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_galleries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('type');
            $table->string('attachment');
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('add_by');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('delete_status')->default(0);
            $table->timestamps();
          
        });

         Schema::table('property_galleries', function(Blueprint $table) {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_galleries');
    }
}
