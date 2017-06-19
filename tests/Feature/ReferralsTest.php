<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use Auth;

class ReferralsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {

    	$user = User::inRandomOrder()->first();    	
    	Auth::loginUsingId($user->id);	
		$response = $this->visit('/referrals');
		$this->assertEquals( 200, $response->response->getStatusCode() );
        $this->assertTrue(true);
    }
}
