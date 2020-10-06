<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->increments('vehicle_model_id');
            $table->string('vehicle_model_name');
            $table->unsignedInteger('vehicle_type_id');
            $table->unsignedInteger('vehicle_brand_id');
            $table->timestamps();

            $table->foreign('vehicle_type_id')
            ->references('vehicle_type_id')
            ->on('vehicle_types')
            ->onUpdate('CASCADE')
            ->onDelete('RESTRICT');

            $table->foreign('vehicle_brand_id')
            ->references('vehicle_brand_id')
            ->on('vehicle_brands')
            ->onUpdate('CASCADE')
            ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_models');
    }
}
