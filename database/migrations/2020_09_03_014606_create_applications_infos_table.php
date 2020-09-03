<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_name');
            $table->string('app_icon')->default('icon.png');
            $table->string('app_bundle');
            $table->string('app_version');
            $table->string('app_arrangement')->default('0');
            $table->string('app_size');
            $table->string('app_ipa');
            $table->string('app_folder');
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
        Schema::dropIfExists('applications_infos');
    }
}
