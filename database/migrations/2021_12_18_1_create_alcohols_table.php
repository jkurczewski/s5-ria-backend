<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlcoholsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alcohols', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('alcohol_name');
            $table->string('alcohol_type');
            $table->string('alcohol_strength');
            $table->string('alcohol_profile_smell');
            $table->string('alcohol_profile_taste');
            $table->string('alcohol_profile_finish');
            $table->string('alcohol_image_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alcohols');
    }
}
