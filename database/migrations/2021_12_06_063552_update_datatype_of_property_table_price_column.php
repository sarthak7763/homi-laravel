<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDatatypeOfPropertyTablePriceColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

         Schema::table('properties', function (Blueprint $table) {
            $table->float('base_price',17, 2)->nullable()->change();
            $table->float('price_from',17, 2)->nullable()->change();
            $table->float('price_to',17, 2)->nullable()->change();
        });

      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('properties', function (Blueprint $table) {
            //
        });
    }
}
