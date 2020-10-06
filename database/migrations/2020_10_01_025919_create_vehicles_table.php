<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('vehicle_id');
            $table->string('vehicle_number')->unique();
            $table->unsignedInteger('vehicle_model_id');
            $table->unsignedInteger('customer_id');
            $table->timestamps();

            $table->foreign('vehicle_model_id')
            ->references('vehicle_model_id')
            ->on('vehicle_models')
            ->onUpdate('CASCADE')
            ->onDelete('RESTRICT');

            $table->foreign('customer_id')
            ->references('customer_id')
            ->on('customers')
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
        Schema::dropIfExists('vehicles');
    }
}
