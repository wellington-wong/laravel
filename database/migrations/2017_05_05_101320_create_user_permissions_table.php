<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->tinyInteger('value')->unsigned();
            $table->timestamps();
            $table->index(['user_id', 'permission_id', 'value']);
        });

        Schema::create('user_permission_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('permission');
            $table->index(['id', 'permission']);
            //$table->timestamps();
        });

        DB::table('user_permission_types')->insert([
            ['permission'=>'can_create_account'],
            ['permission'=>'can_edit_account'],
            ['permission'=>'can_submit_referral'],
            ['permission'=>'can_track_referral'],
            ['permission'=>'can_submit_member_referral'],
            ['permission'=>'can_edit_member_information'],
            ['permission'=>'can_export_member_information'],
            ['permission'=>'can_change_referral_statuses'],
            ['permission'=>'can_add_delete_admin'],
            ['permission'=>'can_define_user_roles'],
            ['permission'=>'can_add_change_billing_information'],
            ['permission'=>'can_login_super_admin_all_accounts']
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_permissions');
        Schema::drop('user_permission_types');
    }
}
