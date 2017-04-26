<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id');
            $table->string('company_name');
            $table->string('subdomain');
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->increments('user_id');
            $table->integer('company_id');
            $table->timestamps();
        });

        Schema::create('referrals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('referrer_id');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });

        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country', 2)->nullable();
            $table->string('country_code', 3)->nullable();
            $table->string('phone', 15);
            $table->tinyInteger('type')->nullable();
            $table->timestamps();
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address', 100);
            $table->string('address2', 25)->nullable();
            $table->string('city');
            $table->string('state', 2);
            $table->string('zip', 11);
            $table->unique(['address', 'address2', 'zip']);
            $table->timestamps();
            //$table->
        });

        Schema::create('user_phone', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('phone_id');
            $table->boolean('default')->default(0);
        });

        Schema::create('user_address', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('address_id');
            $table->boolean('default')->default(0);
        });

        Schema::create('company_phone', function (Blueprint $table) {
            $table->integer('company_id');
            $table->integer('phone_id');
            $table->boolean('default')->default(0);
        });

        Schema::create('company_address', function (Blueprint $table) {
            $table->integer('company_id');
            $table->integer('address_id');
            $table->boolean('default')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('phones');
        Schema::dropIfExists('addresses');

        Schema::dropIfExists('user_phone');
        Schema::dropIfExists('user_address');
        Schema::dropIfExists('company_phone');
        Schema::dropIfExists('company_address');
    }
}
