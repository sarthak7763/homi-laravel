<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCoulmnBidTypeIntoBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
       Schema::table('bids', function (Blueprint $table) {
            $table->string("bid_type")->default('new')->after('bid_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bids', function (Blueprint $table) {
            
        });
    }
}
