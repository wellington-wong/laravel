<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Company;
use App\User;
use App\RoleUser;

class MembersTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testMembers()
    {
        // Get a valid company
        $company = null;
        while ($company == null) {
            $company_id = RoleUser::where('role_id', '<>', 1)->inRandomOrder()->first()->company_id;
            $company = Company::find($company_id);       
        }

        // Get a valid user
        $user = null;
        while ($user == null) { 
            $user_id = RoleUser::where('role_id', '<>', 1)->where('company_id', $company_id)->inRandomOrder()->first()->user_id;
            $user = User::find($user_id);     
        }
        
        // Visit subdomain
        Browser::$baseUrl = 'https://'. $company->subdomain . '.' . env('DOMAIN');

        // Perform browser test
        $this->browse(function (Browser $browser) use ($user_id) {
            $browser->loginAs($user_id)
                ->visit('/members')
                ->waitForText('Admins')
                ->assertSee('Admins')
                ->waitForText('Members')
                ->assertSee('Members');
        });
    }
}
