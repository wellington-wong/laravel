<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Company;

class CompanyTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCompanyProfile()
    {
        // Visit random subdomain
        $subdomain = Company::inRandomOrder()->first()->subdomain;
        Browser::$baseUrl = 'https://'. $subdomain . '.' . env('DOMAIN');

        // Perform browser test
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::inRandomOrder()->first()->id)
                ->visit('/company/' . Company::inRandomOrder()->first()->id)
                ->assertSee('Company Name')
                ->assertSee('Company Number')
                ->assertSee('Company Email')
                ->assertSee('Company Website')
                ->assertSee('Company Address Line 1')
                ->assertSee('Address Line 2')
                ->assertSee('City')
                ->assertSee('States')
                ->assertSee('Zip Code')
                ->assertSee('Billing')
                ->assertSee('Membership Role')
                ->assertSee('Questions about your plan?');
        });
    }
}
