<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    /**
     * A Dusk test for registration step 1.
     *
     * @return void
     */
    public function testRegisterStep1()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->assertSee('Basic package')
                    ->assertSee('We need some basic information about you to get started.')
                    ->assertSee('*Password must be 8 characters and contain a number and a special character.')
                    ->assertSee('BACK')
                    ->assertSee('NEXT')
                    ->assertSee('Your Info')
                    ->assertSee('Company Info')
                    ->assertSee('Billing Information')
                    ->assertSee('Form Builder')
                    ->assertSee('Reward Info')
                    ->assertSee('Review');
        });
    }

    /**
     * A Dusk test for registration step 2.
     *
     * @return void
     */
    public function testRegisterStep2()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register');
        });
    }
}
