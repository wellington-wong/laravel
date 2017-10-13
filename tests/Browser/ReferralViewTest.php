<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Company;
use App\RoleUser;
use App\Referral;

class ReferralViewTest extends DuskTestCase
{
    /**
     * A Dusk test for referral view.
     *
     * @return void
     */
    public function testReferralView()
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

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/referral/view/' . Referral::inRandomOrder()->first()->id)
                ->assertSee('Referral History')
                ->assertSee('Date')
                ->assertSee('Referral Id')
                ->assertSee('Details')
                ->assertSee('Referral Details')
                ->assertSee('ID')
                ->assertSee('Label')
                ->assertSee('Value');
        });
    }
}
