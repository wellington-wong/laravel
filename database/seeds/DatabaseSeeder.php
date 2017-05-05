<?php

use Illuminate\Database\Seeder;
use App\User;

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
	        $user->usertype = User::USERTYPE_GLOBALADMIN;
	        $user->user_template_id = 1;
	        $user->save();
        }
    }
}
