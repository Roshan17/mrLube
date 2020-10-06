<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFullServiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('full_service_details', function (Blueprint $table) {
            $table->increments('fullservice_details_id');
            $table->unsignedInteger('service_record_id');
            $table->bigInteger('current_mileage');
            $table->bigInteger('next_service_mileage');
            $table->string('oil_changed');
            $table->string('airfilter_changed');
            $table->string('ac_filter_changed');
            $table->string('gear_oil_changed');
            $table->timestamps();

            $table->foreign('service_record_id')
            ->references('service_record_id')
            ->on('service_records')
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
        Schema::dropIfExists('full_service_details');
    }
}
