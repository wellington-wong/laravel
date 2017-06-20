<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveThreadIdFromLogsEmailAddSubjectBody extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs_email', function (Blueprint $table) {
            if(Schema::hasColumn('logs_email', 'thread_id')) {
                $table->dropColumn('thread_id');
            }
            $table->string('subject')->after('company_id')->nullable();
            $table->string('body')->after('subject')->nullable();
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
            $table->integer('thread_id')->unsigned()->after('recipient_id');
            if(Schema::hasColumn('logs_email', 'subject')) {
                $table->dropColumn('subject');
            }
            if(Schema::hasColumn('logs_email', 'body')) {
                $table->dropColumn('body');
            }
        });
    }
}
