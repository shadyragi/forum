<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class markReplyTest extends TestCase
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

    public function testThreadOwnerCanMarkReplyAsTheBestReply()
    {
    	$user = factory('App\User')->create();

    	$this->actingAs($user);

    	$thread = factory('App\Thread')->create(['user_id' => $user->id]);

    	$reply = factory('App\Reply')->create(['thread_id' => $thread->id, 'marked' => 0]);

    	$this->put('/replies/'. $reply->id . '/mark');

    	$this->seeInDatabase('replies', [
    		'id' => $reply->id,
    		'marked' => 1
    	]);


    }
}
