<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class replyTest extends TestCase
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

    public function testReplyHasOwner()
    {
    	$reply = factory('App\Reply')->create(['user_id' => 10]);

    	$this->assertInstanceOf('App\User', $reply->owner);
    }

    public function testAuthenticatedUserCanLeaveReply()
    {
    	$thread = factory('App\Thread')->create();

    	$user   = factory('App\User')->create();

    	$reply  = factory('App\Reply')->create();

    	$this->actingAs($user);

    	$this->post($thread->path().'/replies', $reply->toArray());

    	$this->visit($thread->path())->see($reply->body);
    }

    

}
