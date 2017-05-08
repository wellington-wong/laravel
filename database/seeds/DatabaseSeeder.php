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

        $owner = new Role();
        $owner->name         = 'member';
        $owner->display_name = 'Member'; // optional
        $owner->description  = 'User is allowed to create and edit accounts; submit and track referrals'; // optional
        $owner->save();

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Admin'; // optional
        $admin->description  = 'User is allowed to submit and change referral statuses; edit and export member information'; // optional
        $admin->save();

        $admin = new Role();
        $admin->name         = 'superAdmin';
        $admin->display_name = 'Super Admin'; // optional
        $admin->description  = 'User is allowed to submit on behalf of member and change referral statuses; edit and export member information; add/delete admins, defined user roles and add/change billing information'; // optional
        $admin->save();

        $admin = new Role();
        $admin->name         = 'globalAdmin';
        $admin->display_name = 'Global Admin'; // optional
        $admin->description  = 'User is allowed to login as super admin for all accounts; submit on behalf of member and change referral statuses; export member information; add/delete admins, defined user roles and add/change billing information'; // optional
        $admin->save();

    }
}
