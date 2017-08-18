<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRewardRatioToStringInRewardSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reward_settings', function (Blueprint $table) {
            $table->string('reward_ratio')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reward_settings', function (Blueprint $table) {
            $table->integer('reward_ratio')->nullable()->change();
        });
    }
}
