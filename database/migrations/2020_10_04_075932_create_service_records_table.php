<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_records', function (Blueprint $table) {
            $table->increments('service_record_id');
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('service_type_id');
            $table->unsignedInteger('vehicle_id');
            $table->dateTime('service_date');
            $table->timestamps();

            $table->foreign('employee_id')
            ->references('employee_id')
            ->on('employees')
            ->onUpdate('CASCADE')
            ->onDelete('RESTRICT');

            $table->foreign('service_type_id')
            ->references('service_type_id')
            ->on('service_types')
            ->onUpdate('CASCADE')
            ->onDelete('RESTRICT');

            $table->foreign('vehicle_id')
            ->references('vehicle_id')
            ->on('vehicles')
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
        Schema::dropIfExists('service_records');
    }
}
