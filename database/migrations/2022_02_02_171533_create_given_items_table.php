<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGivenItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('given_items', function (Blueprint $table) {
            $table->id();
            //@TODO pivot z tabela characters
//            $table->unsignedBigInteger('user_id')->index();
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->unsignedBigInteger('investigation_id')->index();
//            $table->foreign('investigation_id')->references('id')->on('investigations')->onDelete('cascade');
//            $table->primary(['user_id', 'investigation_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('given_items');
    }
}
