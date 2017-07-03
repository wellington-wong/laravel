<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferralIdToReferralValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referral_values', function (Blueprint $table) {
            $table->integer('referral_id')->after('id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referral_values', function (Blueprint $table) {
            if(Schema::hasColumn('referral_values', 'referral_id')) {
                $table->dropColumn('referral_id');
            }
        });
    }
}
