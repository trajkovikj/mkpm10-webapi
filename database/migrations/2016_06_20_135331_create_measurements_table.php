<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurement', function (Blueprint $table) {
            $table->string('id', 36);
            $table->string('station_id', 36);
            $table->dateTime('date');

            $table->double('pm10');
            $table->double('pm25');
            $table->double('o3');
            $table->double('co');
            $table->double('no2');
            $table->double('so2');

            $table->timestamps();

            $table->primary('id');
            $table->foreign('station_id')->references('id')->on('station')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('measurement');
    }
}
