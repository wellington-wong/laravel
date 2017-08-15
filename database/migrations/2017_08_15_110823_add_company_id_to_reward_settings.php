<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdToRewardSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reward_settings', function (Blueprint $table) {
            $table->integer('company_id')->after('id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reward_settings', function (Blueprint $table) {
            if(Schema::hasColumn('reward_settings', 'company_id')) {
                $table->dropColumn('company_id');
            }
        });
    }
}
