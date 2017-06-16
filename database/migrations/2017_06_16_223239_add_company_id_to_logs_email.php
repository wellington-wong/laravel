<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdToLogsEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs_email', function (Blueprint $table) {
            $table->integer('company_id')->after('thread_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('logs_email', function (Blueprint $table) {
            if(Schema::hasColumn('logs_email', 'company_id')) {
                $table->dropColumn('company_id');
            }
        });
    }
}
