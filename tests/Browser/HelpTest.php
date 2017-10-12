<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\RoleUser;
use App\Company;

class HelpTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testHelp()
    {
        // Get a valid company
        $company = null;
        while ($company == null) {
            $company_id = RoleUser::where('role_id', '<>', 1)->inRandomOrder()->first()->company_id;
            $company = Company::find($company_id);       
        }

        Browser::$baseUrl = 'https://'. $company->subdomain . '.' . env('DOMAIN');

        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::inRandomOrder()->first()->id)
                    ->visit('/help')
                    ->assertSee('Need Help?');
        });
    }
}
