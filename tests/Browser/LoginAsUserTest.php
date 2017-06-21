<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Company;

class LoginAsUserTest extends DuskTestCase
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
        
        // Perform browser test
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::inRandomOrder()->first()->id)
                ->visit('/global-settings/login-as-user')
                ->waitForText('Login as User')
                ->assertSee('Login as User');
        });
    }
}
