<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealEstateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('real_estate_id');
            $table->text('name');
            $table->text('description')->nullable();
            $table->text('address_line_1');
            $table->text('address_line_2')->nullable();
            $table->text('zip');
            $table->text('city');
            $table->text('country');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_addresses');
    }
}
