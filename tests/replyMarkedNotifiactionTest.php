<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class replyMarkedNotifiactionTest extends TestCase
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

    public function testUserReceiveNotificationWhenHisReplyIsMarked()
    {
    	$threadOwner = factory('App\User')->create();

    	$replyOwner = factory('App\User')->create();

    	$this->actingAs($threadOwner);

    	$thread = factory('App\Thread')->create(['user_id' => $threadOwner->id]);

    	$reply  = factory('App\Reply')->create(['thread_id' => $thread->id, 'user_id' => $replyOwner->id]);

    	$this->put('/replies/' . $reply->id . '/mark' );

    	$this->seeInDatabase('notifications', [
    		'notifiable_id' => $replyOwner->id,

    	]);

    }

}
