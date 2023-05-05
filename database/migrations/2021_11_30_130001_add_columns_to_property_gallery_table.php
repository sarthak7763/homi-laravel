<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPropertyGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_galleries', function (Blueprint $table) {
            $table->tinyInteger('is_featured')->default(0)->after('id');
            $table->tinyInteger('position')->default(0)->after('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_galleries', function (Blueprint $table) {
            //
        });
    }
}
