<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStripeDataToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('stripe_id')->after('footer_color')->nullable();
            $table->string('card_brand')->after('stripe_id')->nullable();
            $table->string('card_last_four')->after('card_brand')->nullable();
            $table->timestamp('trial_ends_at')->after('card_last_four')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            if(Schema::hasColumn('users', 'stripe_id')) {
                $table->dropColumn('stripe_id');
            }
            if(Schema::hasColumn('users', 'card_brand')) {
                $table->dropColumn('card_brand');
            }
            if(Schema::hasColumn('users', 'card_last_four')) {
                $table->dropColumn('card_last_four');
            }
            if(Schema::hasColumn('users', 'trial_ends_at')) {
                $table->dropColumn('trial_ends_at');
            }
        });
    }
}
