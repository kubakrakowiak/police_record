<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLicenseLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_license_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('log_type');
            $table->string('type');
            $table->string('owner');
            $table->integer('digit');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->on('pr_users')->references('id');
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
        Schema::dropIfExists('user_license_logs');
    }
}
