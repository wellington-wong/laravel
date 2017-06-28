<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropReferralFormAddFormDataToCompanyReferralForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('referral_form');
        Schema::table('company_referral_forms', function (Blueprint $table) {
            if(Schema::hasColumn('company_referral_forms', 'referral_form')) {
                $table->dropColumn('referral_form');
            }
            $table->string('raw_form_data')->after('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('referral_form', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable()->unsigned();
            $table->string('field');
            $table->string('value');
            $table->string('default_value');
            $table->string('raw_json');
            $table->timestamps();
        });
        Schema::table('company_referral_forms', function (Blueprint $table) {
            $table->integer('referral_form');
            if(Schema::hasColumn('company_referral_forms', 'raw_form_data')) {
                $table->dropColumn('raw_form_data');
            }
        });
    }
}
