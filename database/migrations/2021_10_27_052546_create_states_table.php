<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('country_id');
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('delete_status')->default('0');
            $table->timestamps();
        });

        Schema::table('states', function(Blueprint $table) {
            $table->foreign('country_id')
            ->references('id')
            ->on('countries')
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
        Schema::dropIfExists('states');
    }
}
