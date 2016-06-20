<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('city', function (Blueprint $table) {
            $table->string('id', 36);
            $table->string('name', 30);
            $table->double('lat');
            $table->double('lng');
            $table->integer('zoom_level');

            $table->double('north');
            $table->double('south');
            $table->double('east');
            $table->double('west');

            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('city');
    }
}
