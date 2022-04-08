<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterCrimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crime_character', function (Blueprint $table) {
            $table->unsignedBigInteger('crime_id')->index();
            $table->foreign('crime_id')->references('id')->on('crimes')->onDelete('cascade');
            $table->integer('character_id')->index();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_crimes');
    }
}
