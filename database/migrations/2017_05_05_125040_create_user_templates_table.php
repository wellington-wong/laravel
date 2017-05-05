<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subdomain_id')->unsigned();
            $table->string('name');

            $table->boolean('can_create_account')->default(0);
            $table->boolean('can_edit_account')->default(0);
            $table->boolean('can_submit_referral')->default(0);
            $table->boolean('can_track_referral')->default(0);
            $table->boolean('can_submit_member_referral')->default(0);
            $table->boolean('can_edit_member_information')->default(0);
            $table->boolean('can_export_member_information')->default(0);
            $table->boolean('can_change_referral_statuses')->default(0);
            $table->boolean('can_add_delete_admin')->default(0);
            $table->boolean('can_define_user_roles')->default(0);
            $table->boolean('can_add_change_billing_information')->default(0);
            $table->boolean('can_login_super_admin_all_accounts')->default(0);

            $table->timestamps();
        });

        DB::table('user_templates')->insert(['id'=>4, 'subdomain_id'=>0, 'name'=>'Member',
            'can_create_account'=>1, 'can_edit_account'=>1, 'can_submit_referral'=>1, 'can_track_referral'=>1]);

        DB::table('user_templates')->insert(['id'=>3, 'subdomain_id'=>0, 'name'=>'Admin',
            'can_submit_member_referral'=>1, 'can_edit_member_information'=>1, 'can_export_member_information'=>1, 'can_change_referral_statuses'=>1]);

        DB::table('user_templates')->insert(['id'=>2, 'subdomain_id'=>0, 'name'=>'Super Admin',
            'can_submit_member_referral'=>1, 'can_edit_member_information'=>1, 'can_export_member_information'=>1, 'can_change_referral_statuses'=>1,
            'can_add_delete_admin'=>1, 'can_define_user_roles'=>1, 'can_add_change_billing_information'=>1]);

        DB::table('user_templates')->insert(['id'=>1, 'subdomain_id'=>0, 'name'=>'Global Admin',
            'can_submit_member_referral'=>1, 'can_export_member_information'=>1, 'can_change_referral_statuses'=>1,
            'can_add_delete_admin'=>1, 'can_define_user_roles'=>1, 'can_add_change_billing_information'=>1, 'can_login_super_admin_all_accounts'=>1]);

        Schema::table('users', function($table) {
           $table->integer('user_template_id')->unsigned()->default(0);
           $table->string('usertype', 20);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_templates');
        Schema::table('users', function($table) {
            $table->dropColumn('user_template_id');
            $table->dropColumn('usertype');
        });
    }
}
