<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id(); 
            $table->text('title')->nullable();
            $table->string('attachment')->nullable();
            $table->unsignedBigInteger('add_by');
            $table->unsignedBigInteger('reason_type')->nullable();
            $table->string('complaint_no')->unique()->nullable();
            $table->longtext('description')->nullable();
            $table->string('complaint_status');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('delete_status')->default(0);
           
            $table->timestamps();
        });

         Schema::table('complaints', function(Blueprint $table) {
            $table->foreign('add_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')->onUpdate("cascade");

             $table->foreign('reason_type')
            ->references('id')
            ->on('reasons')
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
        Schema::dropIfExists('complaints');
    }
}
