<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string("title");
            $table->text("logo_store");
            $table->text("app_bundle");
            $table->text("description");
            $table->text("keywords");
            $table->text("conditions_order");
            $table->integer("status_store");
            $table->integer("status_orders");
            $table->string("price_order");
            $table->string("one_signal_app_key");
            $table->string("one_signal_app_id");
            $table->string("twitter_account");
            $table->string("snapchat_account");
            $table->string("telegram_account");
            $table->string("whatsapp_account");
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
        Schema::dropIfExists('settings');
    }
}
