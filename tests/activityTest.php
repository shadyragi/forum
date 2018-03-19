<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class activityTest extends TestCase
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

    public function testActivityIsRecordedWhenThreadIsCreated()
    {
    	$user   = factory('App\User')->create();

    	$this->actingAs($user);

    	$thread = factory('App\Thread')->create();

    	$this->seeInDatabase('activities', [
    		'subject_id' => $thread->id,
    		'type'       => 'created_thread'
    		]);

    }

    public function testActivityIsRecordedWhenReplyIsCreated()

    {
    	$user = factory('App\User')->create();

    	$this->actingAs($user);

    	$reply = factory('App\Reply')->create();

    	$this->seeInDatabase('activities', [
    		'type' => 'created_reply',
    		'subject_id' => $reply->id
    		]);
    }

    public function testActivityIsRecordedWhenRelpyIsLiked()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $reply = factory('App\Reply')->create();

        $this->post('/replies/'.$reply->id .'/like');

        $this->seeInDatabase('activities', [
            'type' => 'created_Like'
            ]);
    }
}
