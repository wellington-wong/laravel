<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSubjectMessageFromLogsEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs_email', function (Blueprint $table) {
            if(Schema::hasColumn('logs_email', 'subject')) {
                $table->dropColumn('subject');
            }
            if(Schema::hasColumn('logs_email', 'message')) {
                $table->dropColumn('message');
            }
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
            $table->string('subject');
            $table->string('message');
        });
    }
}
