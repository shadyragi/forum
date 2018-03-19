<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
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

    public function testUserCanDeleteThread()
    {
    	$user = factory('App\User')->create();

    	$thread = factory('App\Thread')->make();

    	$this->post('/threads', $thread->toArray());

    	$this->actingAs($user);

    	$this->delete('/threads/'.$thread->id);

    	$this->visit('/threads?by='.$user->name)
    		 ->dontsee($thread->title);
    }

    public function testOnlyAuthorizedUsersCanDeleteTheirThreads()
    {
    	$user = factory('App\User')->create();

        $this->actingAs($user);


    	$user2 = factory('App\User')->create();

    	$thread = factory('App\Thread')->create(['user_id' => $user->id]);

    	$thread2 = factory('App\Thread')->create(['user_id' => $user2->id]);

    	

    	$this->delete('/threads/'.$thread2->id);

    	$this->dontSeeInDatabase('threads', [
            'id' => $thread2->id
            ]);
             $this->dontSeeInDatabase('replies', [
                'thread_id' => $thread2->id
                ]);


    }

    public function testOnlyAuthorizedUsersCanDeleteTheirReplies()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Thread')->create();

        $reply  = factory('App\Reply')->create(['thread_id' => $thread->id, 'user_id' => $user->id]);

        $reply2 = factory('App\Reply')->create(['thread_id' => $thread->id, 'user_id' => 5]);


        

        $this->delete('/replies/'.$reply->id);

        $this->delete('/replies/'.$reply2->id);

        $this->dontSeeInDatabase('replies', [
            'body' => $reply->body
            ]);
            $this->SeeInDatabase('replies', [
                'body' => $reply2->body
                ]);
    }

    public function testOnlyAuthorizedUsersCanEditTheirReply()
    {
        $user = factory("App\User")->create();

        $this->actingAs($user);

        $thread = factory('App\Thread')->create();

        $reply  = factory('App\Reply')->create(['thread_id' => $thread, 'user_id' => $user->id]);

        $updatedReply = factory("App\Reply")->make(['body' => 'updated']);

        $this->patch('/replies/'. $reply->id . '/update', $updatedReply->toArray());

        $this->SeeInDatabase('replies', [
            'id' => $reply->id,
            'body' => $updatedReply->body
            ]);

    }
}
