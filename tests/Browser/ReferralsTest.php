<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class ReferralsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testView()
    {

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::inRandomOrder()->first()->id)
                ->visit('/referrals')
                ->waitForText('Referrals');
        });
    }
}
