<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressToRealEstate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            $table->text('street')->nullable()->after('description');
            $table->text('number')->nullable()->after('street');
            $table->text('zip')->nullable()->after('number');
            $table->text('city')->nullable()->after('zip');
            $table->text('country')->nullable()->after('zip');
            $table->integer('show')->nullable()->after('country');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('real_estates', function (Blueprint $table) {
            //
        });
    }
}
