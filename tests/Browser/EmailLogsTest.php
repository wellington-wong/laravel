<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class EmailLogsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testEmailLogs()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::inRandomOrder()->first()->id)
                ->visit('/email-logs')
                ->waitForText('Email Logs')
                ->assertSee('Email Logs');
        });
    }
}
