<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterInvestigationPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_investigation', function (Blueprint $table) {
            $table->integer('character_id')->index();
            $table->foreign('character_id')->references('id')->on('characters')->onDelete('cascade');
            $table->unsignedBigInteger('investigation_id')->index();
            $table->foreign('investigation_id')->references('id')->on('investigations')->onDelete('cascade');
            $table->primary(['character_id', 'investigation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patrol_user');
    }
}
