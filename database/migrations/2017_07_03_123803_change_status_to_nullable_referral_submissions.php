<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStatusToNullableReferralSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referral_submissions', function (Blueprint $table) {
            $table->integer('referrer_id')->unsigned()->change();
            $table->integer('company_id')->unsigned()->change();
            $table->integer('user_id')->unsigned()->change();
            $table->integer('as_admin_id')->unsigned()->change()->nullable();
            $table->integer('status')->unsigned()->default(1)->change();
            $table->string('note')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referral_submissions', function (Blueprint $table) {
            $table->integer('referrer_id')->change();
            $table->integer('company_id')->change();
            $table->integer('user_id')->change();
            $table->integer('as_admin_id')->change()->nullable(false);
            $table->integer('status')->change();
            $table->string('note')->change();
        });
    }
}
