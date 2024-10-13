<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();$table->string('name');
            $table->unsignedBigInteger('state_id');
            $table->tinyInteger('status')->default('1');
            $table->tinyInteger('delete_status')->default('0');
            $table->timestamps();
        });

        Schema::table('cities', function(Blueprint $table) {
            $table->foreign('state_id')
            ->references('id')
            ->on('states')
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
        Schema::dropIfExists('cities');
    }
}
