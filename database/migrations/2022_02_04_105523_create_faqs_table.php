<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqsTable extends Migration
{
    
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->longText('question')->nullable();
            $table->longText('answer')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('add_by');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('delete_status')->default(0);
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('faqs');
    }
}
