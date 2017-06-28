<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTemplateNameToCompanyReferralForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_referral_forms', function (Blueprint $table) {
            $table->string('template_name')->after('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_referral_forms', function (Blueprint $table) {
            if(Schema::hasColumn('company_referral_forms', 'template_name')) {
                $table->dropColumn('template_name');
            }
        });
    }
}
