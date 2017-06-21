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
        // Visit random subdomain
        $subdomain = Company::inRandomOrder()->first()->subdomain;
        Browser::$baseUrl = 'https://'. $subdomain . '.' . env('DOMAIN');

        // Perform browser test
        $this->browse(function (Browser $browser) {
            $browser->loginAs(RoleUser::where('role_id', '<>', 1)->inRandomOrder()->first()->user_id)
                ->visit('/members')
                ->waitForText('Admins')
                ->assertSee('Admins')
                ->waitForText('Members')
                ->assertSee('Members');
        });
    }
}
