<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Company;
use App\RoleUser;

class LoginAsUserTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoginAsUser()
    {
        // Visit random subdomain
        $subdomain = Company::inRandomOrder()->first()->subdomain;
        Browser::$baseUrl = 'https://'. $subdomain . '.' . env('DOMAIN');

        // Perform browser test
        $this->browse(function (Browser $browser) {
            $browser->loginAs(RoleUser::where('role_id', 4)->inRandomOrder()->first()->user_id)
                ->visit('/global-settings/login-as-user')
                ->assertSee('Login as User')
                ->click('.table-login-as-wrapper td a')
                ->assertSee('Successfully logged in as')
                ->assertSee('Login as original');
        });
    }
}
