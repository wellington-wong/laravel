<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropReferralSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('referral_submissions');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('referral_submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('referrer_id');
            $table->integer('subdomain_id');
            $table->integer('user_id');
            $table->integer('as_admin_id');
            $table->integer('status');
            $table->string('note');
            $table->timestamps();
        });
    }
}
