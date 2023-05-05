<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdateStatusTypeColumnIntoCitiesTable extends Migration
{
    
      public function up()
    {
      Schema::table('cities', function (Blueprint $table) {
        $table->enum('status_type',['','Auto','Manual'])->after('status')->default("")->comment('manual means = when status disabled by admin, auto when status disabled by foreign key realtion');
     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            //
        });
    }
}
