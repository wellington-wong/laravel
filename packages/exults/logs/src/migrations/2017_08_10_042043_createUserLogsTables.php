<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLogsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('userlogs.user_logs_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('as_user')->unsigned();
            $table->string('route', 2047);
            $table->string('method')->nullable();
            $table->timestamps();
        });

        Schema::create(config('userlogs.user_logs_request_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('log_id')->unsigned();
            $table->string('key');
            $table->string('value', 1023);
        });

        Schema::create(config('userlogs.user_logs_split_table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('log_id')->unsigned();
            $table->string('path');
            $table->tinyInteger('position')->nullable();
        });

        Schema::create(config('userlogs.user_logs_time_table'), function (Blueprint $table) {
            $table->bigInteger('log_id')->unsigned();
            $table->double('seconds', 8,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('userlogs.user_logs_table'));
        Schema::dropIfExists(config('userlogs.user_logs_request_table'));
        Schema::dropIfExists(config('userlogs.user_logs_split_table'));
        Schema::dropIfExists(config('userlogs.user_logs_time_table'));
    }
}
