<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable();
            $table->string('subject',255)->nullable();
            $table->string('action',255);
            $table->longText('body');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_templates');
    }
}
