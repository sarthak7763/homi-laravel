<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('id');
            $table->string('username')->nullable()->after('name');
            $table->string('first_name')->nullable()->after('username');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('country_std_code')->nullable()->after('last_name');
            $table->string('country_code')->nullable()->after('country_std_code');
            $table->string('country_name')->nullable()->after('country_code');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
