<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\RoleUser;
use App\Company;

class UserViewTest extends DuskTestCase
{
    /**
     * A Dusk test for user view.
     *
     * @return void
     */
    public function testUserView()
    {

        // Get a valid company
        $company = null;
        while ($company == null) {
            $company_id = RoleUser::inRandomOrder()->first()->company_id;
            $company = Company::find($company_id);       
        }

        // Get a valid user
        $user = null;
        while ($user == null) { 
            $user_id = RoleUser::where('company_id', $company_id)->inRandomOrder()->first()->user_id;
            $user = User::find($user_id);     
        }

        // Visit subdomain
        Browser::$baseUrl = 'https://'. $company->subdomain . '.' . env('DOMAIN');
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::inRandomOrder()->first()->id)
                    ->visit('/user/view/' . User::inRandomOrder()->first()->id)
                    ->assertSee('First Name')
                    ->assertSee('Last Name')
                    ->assertSee('Email')
                    ->assertSee('Phone')
                    ->assertSee('Address')
                    ->assertSee('Line 2')
                    ->assertSee('City')
                    ->assertSee('State')
                    ->assertSee('Zip')
                    ->assertSee('Referrals')
                    ->assertSee('Person Referred')
                    ->assertSee('Status')
                    ->assertSee('Date');
        });

    }
}
