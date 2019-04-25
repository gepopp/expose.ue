<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCicleRadiusToRealEstateLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_estate_locations', function (Blueprint $table) {
            $table->integer('radius')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('real_estate_locations', function (Blueprint $table) {
            $table->dropColumn('radius');
        });
    }
}
