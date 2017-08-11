<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Role;
use App\Company;

class ReferralProgramSettingsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {

        // Visit random subdomain
        $subdomain = Company::inRandomOrder()->first()->subdomain;
        Browser::$baseUrl = 'https://'. $subdomain . '.' . env('DOMAIN');

        $this->browse(function (Browser $browser) {
            $browser->loginAs(Role::where('name', 'globalAdmin')->first()->users()->first()->id)
                ->visit('/program-options/referral-program-settings')
                ->assertSee('Custom Company Landing Page')
                ->assertSee('Referral Program Settings');
        });
    }
}
