<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\RoleUser;
use App\Company;

class MessagesTest extends DuskTestCase
{
    /**
     * A Dusk test for messages.
     *
     * @return void
     */
    public function testMessages()
    {

        // Get a valid company
        $company = null;
        while ($company == null) {
            $company_id = RoleUser::inRandomOrder()->first()->company_id;
            $company = Company::find($company_id);       
        }

        // Get a valid user
        $user = null;
        while ($user == null) { 
            $user_id = RoleUser::where('company_id', $company_id)->inRandomOrder()->first()->user_id;
            $user = User::find($user_id);     
        }

        // Visit subdomain
        Browser::$baseUrl = 'https://'. $company->subdomain . '.' . env('DOMAIN');

        $this->browse(function (Browser $browser) use($user) {
            $browser->loginAs($user->id)
            ->visit('/messages')
            ->assertSee('Messages')
            ->assertSee('Subject')
            ->assertSee('From')
            ->assertSee('To')
            ->assertSee('Action')
            ->assertSee('Compose a New Message');
        });
    }
}
