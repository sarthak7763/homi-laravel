<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColumnIntoMailActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mail_actions', function (Blueprint $table) {
            $table->string("action_type")->nullable()->after('id');
        });
    }

    public function down()
    {
         Schema::table('mail_actions', function (Blueprint $table) {
            
        });
    }
   
}
