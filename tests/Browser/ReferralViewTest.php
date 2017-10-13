<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReferralViewTest extends DuskTestCase
{
    /**
     * A Dusk test for referral view.
     *
     * @return void
     */
    public function testReferralView()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/referral/view')
                ->assertSee('Referral History')
                ->assertSee('Referral Details');
        });
    }
}
