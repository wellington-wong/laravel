<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSubdomainIdToCompanyIdInReferralSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referral_submissions', function (Blueprint $table) {
            $table->renameColumn('subdomain_id', 'company_id');
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
            $table->renameColumn('company_id', 'subdomain_id');
        });
    }
}
