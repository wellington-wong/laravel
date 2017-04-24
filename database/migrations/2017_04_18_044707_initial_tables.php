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
            $table->integer('address_id');
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->increments('user_id');
            $table->integer('company_id');
        });

        Schema::create('referrals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->timestamps();
        });

        Schema::create('phones', function (Blueprint $table) {
            $table->increments('id');
            //$table->
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
            $table->string('address2')->nullable();
            $table->string('city');
            $table->string('state', 2);
            $table->string('zip', 10);
            $table->unique(['address', 'address2', 'zip']);
            $table->timestamps();
            //$table->
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
    }
}
