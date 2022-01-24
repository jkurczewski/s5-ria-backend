<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlcoholInDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alcohol_in_drinks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('drink_id')->unsigned();
            $table->integer('alcohol_id')->unsigned();
            $table->string('alcohol_unit');
            $table->string('alcohol_amount');
            $table->timestamps();

            $table->foreign('drink_id')->references('id')->on('drinks')->onDelete('cascade');
            $table->foreign('alcohol_id')->references('id')->on('alcohols')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alcohol_in_drinks');
    }
}
