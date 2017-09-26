<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecipientIdToEmailTemplateRecipients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_template_recipients', function (Blueprint $table) {
            $table->integer('recipient_id')->after('email_template')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_template_recipients', function (Blueprint $table) {
            $table->dropColumn('recipient_id');
        });
    }
}
