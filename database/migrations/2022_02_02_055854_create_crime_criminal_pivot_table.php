<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCrimeCriminalPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crime_criminal', function (Blueprint $table) {
            $table->unsignedBigInteger('crime_id')->index();
            $table->foreign('crime_id')->references('id')->on('crimes')->onDelete('cascade');
            $table->unsignedBigInteger('criminal_id')->index();
            $table->foreign('criminal_id')->references('id')->on('criminals')->onDelete('cascade');
            $table->primary(['crime_id', 'criminal_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crime_criminal');
    }
}
