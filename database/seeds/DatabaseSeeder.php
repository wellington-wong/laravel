<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

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

    }
}
