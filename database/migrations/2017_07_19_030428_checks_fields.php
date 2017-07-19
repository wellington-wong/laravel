<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChecksFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checks', function (Blueprint $table) {
            $table->string('pdf')->nullable()->after('check_number');
            $table->string('thumbnail')->nullable()->after('pdf');
            $table->dropColumn('referral_id');
        });

        Schema::create('check_referral', function (Blueprint $table) {
            $table->integer('check_id')->unsigned();
            $table->integer('referral_id')->unsigned();
            $table->index(['check_id', 'referral_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checks', function (Blueprint $table) {
            $table->dropColumn('pdf');
            $table->dropColumn('thumbnail');
            $table->integer('referral_id')->unsigned();
        });
        Schema::dropIfExists('check_referral');
    }
}
