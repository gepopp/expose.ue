<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealEstateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('real_estate_id');
            $table->boolean('is_public')->default(0);
            $table->text('name');
            $table->text('description')->nullable();
            $table->text('lat_lng')->nullable();
            $table->integer('zoom')->default(12)->nullable();
            $table->text('type', 50)->nullable();
            $table->text('marker')->nullable();
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
        Schema::dropIfExists('real_estate_locations');
    }
}
