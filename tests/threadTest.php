<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class threadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    use DatabaseTransactions;

    //use DatabaseMigrations;
    public function testExample()
    {
        $this->assertTrue(true);
    }
    /*public function testUserCanViewThread()
    {
    	$response = $this->get('/threads');
        
        //$this->status(200, $response);
    }*/

    public function testThreadBelongsToOwner()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\User', $thread->owner);
    }

    public function testThreadBelongsToChannel()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    public function testUserCanViewSingleThread()
    {
        $thread = factory('App\Thread')->create();

        //$response = $this->get('/threads/'.$thread->id);

        $this->visit('/threads/'.$thread->id)->see($thread->title);
        //$this->see($thread->title, $response);
    }

    public function testUserCanReadRepliesAssociatedWithThread()
    {
        $thread = factory('App\Thread')->create();

        $reply  = factory('App\Reply')->create(['thread_id' => $thread->id]);

        $this->visit('/threads/' . $thread->id)->see($reply->body);
    }

    public function testUserCanFilterThreadsByChannel()
    {

       $channel =  factory('App\Channel')->create();

       $thread1 = factory('App\Thread')->create(['channel_id' => $channel->id]);

       $thread2 = factory('App\Thread')->create();

       $this->visit('/threads/'.$channel->slug)
            ->see($thread1->title)
            ->dontsee($thread2->title);


    }

    public function testUserCanFilterThreadsByUsername()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Thread')->create(['user_id' => $user->id]);

        $thread2 = factory('App\Thread')->create();

        $this->visit('/threads?by=' . auth()->user()->name)
             ->see($thread->title)
             ->dontsee($thread2->title);

    }

    public function testUserCanFilterThreadsByPopularity()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Thread')->create();

        $thread_reply = factory('App\Reply', 50)->create(['thread_id' => $thread->id, 'user_id' => $user->id, 'body' => 'test reply']);




        $thread2 = factory('App\Thread')->create();

        $this->visit('/threads?popular=1')
             ->see($thread->title)
             ;
    }

    public function testThreadCanBeSubscribedTo()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Thread')->create();

        $thread->subscribe();

        $this->assertEquals(1, $thread->subscriptions()->count());
    }

    public function testThreadCanBeUnsubscribedfrom()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Thread')->create();

        $thread->unSubscribe();

        $this->assertEquals(0, $thread->subscriptions()->count());
    }
}
