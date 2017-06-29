<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTemplateNameToFormNameOnCompanyReferralForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_referral_forms', function (Blueprint $table) {
            $table->renameColumn('template_name', 'form_name');
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
            $table->renameColumn('form_name', 'template_name');
        });
    }
}
