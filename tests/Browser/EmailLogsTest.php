<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Company;

class EmailLogsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testEmailLogs()
    {
        $subdomain = Company::inRandomOrder()->first()->subdomain;
        Browser::$baseUrl = 'https://'. $subdomain . '.' . env('DOMAIN');
        $this->browse(function (Browser $browser) {
            $browser->loginAs(4)
                ->visit('/program-options/email-logs')
                ->waitForText('Email Logs')
                ->assertSee('Email Logs');
        });
    }
}
