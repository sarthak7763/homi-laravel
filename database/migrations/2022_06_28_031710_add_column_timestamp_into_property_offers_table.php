<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTimestampIntoPropertyOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::table('property_offers', function (Blueprint $table) {
            $table->string('start_timestamp')->nullable()->after('property_id');
            $table->string('end_timestamp')->nullable()->after('start_timestamp');
            $table->tinyInteger('notification_status')->default('0')->after('status');
             $table->tinyInteger('notif_status_cron')->default('0')->after('status');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('property_offers', function (Blueprint $table) {
            //
        });
    }
}
