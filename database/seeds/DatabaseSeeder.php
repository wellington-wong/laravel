<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Permission;
use App\Company;

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

        // Create user roles
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
            $role[$roleProfile[0]] = Role::firstOrCreate($fields);
        }

        // Create user role permissions
        $permissions = array(
            array('create_account', 'Create account', 'A user is allowed to create account.', array('member')),
            array('edit_account', 'Edit account', 'A user is allowed to edit account.', array('member')),
            array('submit_referral', 'Submit referral', 'A user is allowed to submit referral.', array('member')),
            array('track_referral', 'Track referral', 'A user is allowed to track referral.', array('member')),
            array('submit_member_referral', 'Submit member referral', 'A user is allowed to submit member referral.', array('admin', 'superAdmin', 'globalAdmin')),
            array('edit_member_information', 'Edit member information', 'A user is allowed to edit member information.', array('admin', 'superAdmin')),
            array('export_member_information', 'Export member information', 'A user is allowed to export member information.', array('admin', 'superAdmin', 'globalAdmin')),
            array('change_referral_statuses', 'Change referral statuses', 'A user is allowed to change referral statuses.', array('admin', 'superAdmin', 'globalAdmin')),
            array('add_delete_admin', 'Add/delete admin', 'A user is allowed to add/delete admin.', array('superAdmin', 'globalAdmin')),
            array('define_user_roles', 'Define user roles', 'A user is allowed to define user roles.', array('superAdmin', 'globalAdmin')),
            array('add_change_billing_information', 'Change billing information', 'A user is allowed to change billing information.', array('superAdmin', 'globalAdmin')),
            array('login_super_admin_all_accounts', 'Login as super admin for all accounts', 'A user is allowed to login as super admin for all accounts.', array('globalAdmin')),
            array('login_as_user', 'Login as other user', 'A user is allowed to login as another user.', array('globalAdmin')),
        );        
        foreach ($permissions as $permission) {
            $fields = array(
                'name' => $permission[0],
                'display_name' => $permission[1],
                'description' => $permission[2],
            );
            $permissionObj = Permission::firstOrCreate($fields);

            // Assign permission to role according to documentation
            if (isset($permission[3])) {
                foreach ($permission[3] as $roleName) {
                    if (!$role[$roleName]->hasPermission($permissionObj->name)) {
                        $role[$roleName]->attachPermission($permissionObj);
                    }
                }
            }
        }

        $users = array(
            array('exults.referral@gmail.com', 'Zach', 'Hoffman', 'globalAdmin'),
            array('exults.referral.superadmin@gmail.com', 'Super Admin', 'Exults', 'superAdmin'),
            array('exults.referral.admin@gmail.com', 'Admin', 'Exults', 'admin'),
            array('exults.referral.member@gmail.com', 'Member', 'Exults', 'member'),
        );
        $password = 'E*x%u~lts321!';
        $company = Company::find(2);
        // Create users for each role
        foreach ($users as $user) {
            if (!$userObj = User::where('email', $user[0])->first()) {
                $userObj = new User();
                $userObj->first_name = $user[1];
                $userObj->last_name = $user[2];
                $userObj->name = $userObj->first_name . ' ' . $userObj->last_name;
                $userObj->email = $user[0];
                $userObj->password = Hash::make($password);
                //$user->subdomain = 1;
                $userObj->save();

                // Assign role to each user created
                if (isset($role[$user[3]])) {
                    $userObj->attachRole($role[$user[3]], $company);
                }
            }
        }

    }
}
