<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSubscriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->integer('company_id')->after('user_id');
            $table->string('subscription_name')->after('company_id');
            $table->integer('amount')->after('stripe_plan');
            if(Schema::hasColumn('subscriptions', 'name')) {
                $table->dropColumn('name');
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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('name')->after('user_id');
            if(Schema::hasColumn('subscriptions', 'company_id')) {
                $table->dropColumn('company_id');
            }
            if(Schema::hasColumn('subscriptions', 'amount')) {
                $table->dropColumn('amount');
            }
            if(Schema::hasColumn('subscriptions', 'subscription_name')) {
                $table->dropColumn('subscription_name');
            }
        });
    }
}
