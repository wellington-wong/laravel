<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRawFormDataFromStringToBlob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_referral_forms', function (Blueprint $table) {
            if(Schema::hasColumn('company_referral_forms', 'raw_form_data')) {
                $table->dropColumn('raw_form_data');
            }
            $table->binary('raw_form_json')->after('template_name');
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
            if(Schema::hasColumn('company_referral_forms', 'raw_form_json')) {
                $table->dropColumn('raw_form_json');
            }
            $table->string('raw_form_data')->after('template_name');
        });
    }
}
