<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferralIdReferredIdToNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->integer('referral_id')->nullable()->after('read_at');
            $table->integer('referred_id')->nullable()->after('referral_id');
            $table->integer('referral_status')->nullable()->after('referred_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            if(Schema::hasColumn('notifications', 'referral_id')) {
                $table->dropColumn('referral_id');
            }
            if(Schema::hasColumn('notifications', 'referred_id')) {
                $table->dropColumn('referred_id');
            }
            if(Schema::hasColumn('notifications', 'referral_status')) {
                $table->dropColumn('referral_status');
            }
        });
    }
}
