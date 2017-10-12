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
            $browser->visit('/register')
                ->clickLink('NEXT')
                ->waitForText('Tell Us About Your Company');
        });
    }

    /**
     * A Dusk test for registration step 3.
     *
     * @return void
     */
    public function testRegisterStep3()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->waitForText('Billing Information');
        });
    }

    /**
     * A Dusk test for registration step 4.
     *
     * @return void
     */
    public function testRegisterStep4()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->waitForText('What information do you need to follow up with a referral? This is the information your referral club members will enter when submitting a referral.');
        });
    }

    /**
     * A Dusk test for registration step 5.
     *
     * @return void
     */
    public function testRegisterStep5()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->waitForText('How will you reward your members for their qualifying referrals?')
                ->waitForText('Your Reward Ratio *');
        });
    }

    /**
     * A Dusk test for registration step 6.
     *
     * @return void
     */
    public function testRegisterStep6()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->waitForText('Please review the information you have entered.');
        });
    }

    /**
     * A Dusk test for registration submit.
     *
     * @return void
     */
    public function testRegisterSubmit()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->clickLink('NEXT')
                ->waitForText('Please review the information you have entered.')
                ->clickLink('SUBMIT');
        });
    }
}
