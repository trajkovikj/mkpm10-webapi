<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('station', function (Blueprint $table) {
            $table->string('id', 36);
            $table->string('city_id', 36);
            $table->string('description', 30);
            $table->double('lat');
            $table->double('lng');

            $table->timestamps();

            $table->primary('id');
            $table->foreign('city_id')->references('id')->on('city')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('station');
    }
}
