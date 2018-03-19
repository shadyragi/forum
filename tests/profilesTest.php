<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class profilesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseTransactions;

    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testUserHasProfile()
    {
    	$user = factory('App\User')->create();

    	$this->actingAs($user);

    	$this->visit('/profiles/'.$user->name)
    		 ->see($user->name);
    }
}
