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
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::inRandomOrder()->first()->id)
                ->visit('/company/' . Company::inRandomOrder()->first()->id)
                ->waitForText('Membership Role')
                ->assertSee('Membership Role');
        });
    }
}
