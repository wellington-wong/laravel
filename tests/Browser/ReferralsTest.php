<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Company;
use App\RoleUser;
use Carbon\Carbon;

class ReferralsTest extends DuskTestCase
{
    /**
     * A Dusk test admin referrals.
     *
     * @return void
     */
    public function testReferralsAdmin()
    {
        // Prepare url parameters
        $sort = ['asc', 'desc'];
        $column = ['created_at', 'id', 'user_id', 'referred', 'status'];
        $search = ['zach', 'daniel', 'bilal', 'wellington'];
        $date = Carbon::create(2017, 1, 0);
        $parameters = [
            'status' => rand(1, 4),
            'sort' => $sort[array_rand($sort)],
            'column' => $column[array_rand($column)],
            'daterange' => $date->format('m/d/Y') . '|' . $date->addWeeks(rand(1, 52))->format('m/d/Y'),
            'search' => $search[array_rand($search)],
        ];
        
        // Get a valid company
        $company = null;
        while ($company == null) {
            $company = Company::inRandomOrder()->first();
        }

        // Get a valid user
        $user = null;
        while ($user == null) { 
            $user_id = RoleUser::where('company_id', $company->id)->where('role_id', '<>', 1)->inRandomOrder()->first()->user_id;
            $user = User::find($user_id);     
        }

        // Visit subdomain
        Browser::$baseUrl = 'https://'. $company->subdomain . '.' . env('DOMAIN');

        // Perform browser test
        $this->browse(function (Browser $browser) use($parameters, $user_id) {
            $browser->loginAs($user_id)
                ->visit( '/referrals?' . http_build_query($parameters))
                ->assertSee('Referrals Pending Approval')
                ->assertSee('Referrals Pending Reward')
                ->assertSee('Person Referred')
                ->assertSee('Member')
                ->assertSee('Status')
                ->assertSee('Date')
                ->assertSee('Referral ID')
                ->assertSee('Member');
        });
    }
    /**
     * A Dusk test member referrals.
     *
     * @return void
     */
    public function testReferralsMember()
    {
        // Prepare url parameters
        $sort = ['asc', 'desc'];
        $column = ['created_at', 'id', 'user_id', 'referred', 'status'];
        $search = ['zach', 'daniel', 'bilal', 'wellington'];
        $date = Carbon::create(2017, 1, 0);
        $parameters = [
            'status' => rand(1, 4),
            'sort' => $sort[array_rand($sort)],
            'column' => $column[array_rand($column)],
            'daterange' => $date->format('m/d/Y') . '|' . $date->addWeeks(rand(1, 52))->format('m/d/Y'),
            'search' => $search[array_rand($search)],
        ];
        
        // Get a valid company
        $company = null;
        while ($company == null) {
            $company = Company::inRandomOrder()->first();
        }

        // Get a valid user
        $user = null;
        while ($user == null) { 
            $user_id = RoleUser::where('company_id', $company->id)->where('role_id', 1)->inRandomOrder()->first()->user_id;
            $user = User::find($user_id);     
        }

        // Visit subdomain
        Browser::$baseUrl = 'https://'. $company->subdomain . '.' . env('DOMAIN');

        // Perform browser test
        $this->browse(function (Browser $browser) use($parameters, $user_id) {
            $browser->loginAs($user_id)
                ->visit( '/referrals?' . http_build_query($parameters))
                ->assertSee('Referrals Pending Approval')
                ->assertSee('Referrals Pending Reward')
                ->assertSee('Person Referred')
                ->assertSee('Status')
                ->assertSee('Date');
        });
    }
}
