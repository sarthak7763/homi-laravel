<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLotSizeColumnIntoPropertiesTable extends Migration
{
     public function up()
    {
       Schema::table('properties', function (Blueprint $table) {
            $table->string("lot_size")->nullable()->after('property_type');
        });
    }

    public function down()
    {
         Schema::table('properties', function (Blueprint $table) {
            
        });
    }
}
