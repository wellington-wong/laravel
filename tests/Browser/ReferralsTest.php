<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;
use App\Company;
use Carbon\Carbon;

class ReferralsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testReferrals()
    {
        // Prepare url parameters
        $sort = ['asc', 'desc'];
        $column = ['created_at', 'id', 'user_id', 'referred', 'status'];
        $search = ['zach', 'daniel', 'bilal', 'wellington'];
        $date = Carbon::create(2017, 1, 0);
        $subdomain = Company::inRandomOrder()->first()->subdomain;
        Browser::$baseUrl = 'https://'. $subdomain . '.' . env('DOMAIN');

        $parameters = [
            'status' => rand(1, 4),
            'sort' => $sort[array_rand($sort)],
            'column' => $column[array_rand($column)],
            'daterange' => $date->format('m/d/Y') . '|' . $date->addWeeks(rand(1, 52))->format('m/d/Y'),
            'search' => $search[array_rand($search)],
        ];

        // Perform browser test
        $this->browse(function (Browser $browser) use($parameters) {
            $browser->loginAs(User::inRandomOrder()->first()->id)
                ->visit( '/referrals?' . http_build_query($parameters))
                ->waitForText('Referrals')
                ->assertSee('Referrals');
        });
    }
}
