<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Company;
use App\RoleUser;

class EmailLogsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testEmailLogs()
    {
        // Get a valid company
        $company = null;
        while ($company == null) {
            $company_id = RoleUser::where('role_id', '<>', 1)->where('role_id', '<>', 2)->inRandomOrder()->first()->company_id;
            $company = Company::find($company_id);       
        }

        // Get a valid user
        $user = null;
        while ($user == null) { 
            $user_id = RoleUser::where('role_id', '<>', 1)->inRandomOrder()->first()->user_id;
            $user = User::find($user_id);     
        }

        // Visit random subdomain
        $company = Company::find($company_id);
        Browser::$baseUrl = 'https://'. $company->subdomain . '.' . env('DOMAIN');

        // Perform browser test
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user->id)
                ->visit('/program-options/email-logs')
                ->waitForText('Email Logs')
                ->assertSee('Email Logs');
        });
    }
}
