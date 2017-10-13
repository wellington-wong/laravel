<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserViewTest extends DuskTestCase
{
    /**
     * A Dusk test for user view.
     *
     * @return void
     */
    public function testUserView()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($user->id)
                    ->visit('/user/view')
                    ->assertSee('Laravel');
        });
    }
}
