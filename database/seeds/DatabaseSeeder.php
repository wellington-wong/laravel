<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // Create Global Admin 
        if (!$user = User::where('email', 'exults.referral@gmail.com')->first()) {
            $user = new User();
            $user->first_name = "Global";
            $user->last_name = "Admin";
            $user->name = $user->first_name . ' ' . $user->last_name;
            $user->email = "exults.referral@gmail.com";
            $user->password = Hash::make('E*x%u~lts321!');
            //$user->subdomain = 1;
            $user->save();
        }

        // Create user roles if not exist
        $roleProfiles = array(
            array('member', 'Member', 'User is allowed to create and edit accounts; submit and track referrals'),
            array('admin', 'Admin', 'User is allowed to submit and change referral statuses; edit and export member information'),
            array('superAdmin', 'Super Admin', 'User is allowed to submit on behalf of member and change referral statuses; edit and export member information; add/delete admins, defined user roles and add/change billing information'),
            array('globalAdmin', 'Global Admin', 'User is allowed to login as super admin for all accounts; submit on behalf of member and change referral statuses; export member information; add/delete admins, defined user roles and add/change billing information'),
        );
        foreach ($roleProfiles as $roleProfile) {
            $fields = array(
                'name' => $roleProfile[0],
                'display_name' => $roleProfile[1],
                'description' => $roleProfile[2],
            );
            $role = Role::firstOrCreate($fields);
        }

        // Create user role permissions
        $permissions = array(
            array('can_create_account', 'Create account', 'A user is allowed to create account.'),
            array('can_edit_account', 'Edit account', 'A user is allowed to edit account.'),
            array('can_submit_referral', 'Submit referral', 'A user is allowed to submit referral.'),
            array('can_track_referral', 'Track referral', 'A user is allowed to track referral.'),
            array('can_submit_member_referral', 'Submit member referral', 'A user is allowed to submit member referral.'),
            array('can_edit_member_information', 'Edit member information', 'A user is allowed to edit member information.'),
            array('can_export_member_information', 'Export member information', 'A user is allowed to export member information.'),
            array('can_change_referral_statuses', 'Change referral statuses', 'A user is allowed to change referral statuses.'),
            array('can_add_delete_admin', 'Add/delete admin', 'A user is allowed to add/delete admin.'),
            array('can_define_user_roles', 'Define user roles', 'A user is allowed to define user roles.'),
            array('can_add_change_billing_information', 'Change billing information', 'A user is allowed to change billing information.'),
            array('can_login_super_admin_all_accounts', 'Login as super admin for all accounts', 'A user is allowed to login as super admin for all accounts.'),
        );        
        foreach ($permissions as $permission) {
            $fields = array(
                'name' => $permission[0],
                'display_name' => $permission[1],
                'description' => $permission[2],
            );
            $permission = Permission::firstOrCreate($fields);
        }

    }
}
