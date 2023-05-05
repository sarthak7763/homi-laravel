<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmdColumnsIntoPropertiesTable extends Migration
{
     public function up()
    {
       Schema::table('properties', function (Blueprint $table) {
            $table->string("emd_due")->nullable()->after('property_type');
            $table->string("emd_coe")->nullable()->after('emd_due');
            $table->string("emd_amount")->nullable()->after('emd_coe');
        });
    }

    public function down()
    {
         Schema::table('properties', function (Blueprint $table) {
            
        });
    }
}
