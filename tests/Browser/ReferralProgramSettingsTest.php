<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Role;
use App\Company;
use App\RoleUser;

class ReferralProgramSettingsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testReferralProgramSettings()
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

        $this->browse(function (Browser $browser) use ($user_id) {
            $browser->loginAs($user_id)
                ->visit('/program-options/referral-program-settings');
               // ->assertSee('Custom Company Landing Page')
                //->assertSee('Referral Program Settings');
        });
    }
}
