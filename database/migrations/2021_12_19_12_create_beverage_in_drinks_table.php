<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeverageInDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beverage_in_drinks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('drink_id')->unsigned();
            $table->integer('beverage_id')->unsigned();
            $table->string('beverage_unit');
            $table->string('beverage_amount');
            $table->timestamps();

            $table->foreign('drink_id')->references('id')->on('drinks')->onDelete('cascade');
            $table->foreign('beverage_id')->references('id')->on('beverages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beverage_in_drinks');
    }
}
