<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionInDrinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addition_in_drinks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('drink_id')->unsigned();
            $table->integer('addition_id')->unsigned();
            $table->string('addition_unit');
            $table->string('addition_amount');
            $table->timestamps();

            $table->foreign('drink_id')->references('id')->on('drinks')->onDelete('cascade');
            $table->foreign('addition_id')->references('id')->on('additions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addition_in_drinks');
    }
}
