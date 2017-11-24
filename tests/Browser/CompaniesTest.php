<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\RoleUser;

class CompaniesTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCompanies()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(RoleUser::where('role_id', '>', 2)->inRandomOrder()->first()->user_id)
                    ->visit('/companies')
                    ->assertSee('Create Company');
        });
    }
}
