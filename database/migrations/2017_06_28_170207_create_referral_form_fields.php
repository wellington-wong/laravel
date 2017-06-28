<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralFormFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_form_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('referral_form_id');
            $table->boolean('required')->nullable();
            $table->string('type');
            $table->string('label')->nullable();
            $table->string('class')->nullable();
            $table->string('help_text')->nullable();
            $table->string('content')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('name')->nullable();
            $table->string('value')->nullable();
            $table->string('values')->nullable();
            $table->integer('min')->nullable();
            $table->integer('max')->nullable();
            $table->integer('max_length')->nullable();
            $table->integer('step')->nullable();
            $table->boolean('display_inline')->nullable();
            $table->boolean('allow_multiple')->nullable();
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
        Schema::dropIfExists('referral_form_fields');
    }
}
