<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class likesTest extends TestCase
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
    public function testAuthenticatedUserCanLikeReply()
    {
        $user  = factory('App\User')->create();

        $this->actingAs($user);

        $reply = factory('App\Reply')->create(['user_id' => $user->id]);

        $this->post('/replies/'. $reply->id .'/like');

        $this->assertCount(1, $reply->likes);


    }

    public function testGuestUserCanNotLikeReply()
    {
    	$this->post('/replies/1/like');

    	$this->assertRedirectedTo('/login');
    }

    public function testUserCanLikeReplyOnlyOnce()
    {
    	$user = factory('App\User')->create();

    	$this->actingAs($user);

    	$reply = factory('App\Reply')->create();

    	$this->post('/replies/'.$reply->id. '/like');

    	$this->post('/replies/'.$reply->id. '/like');

    	$this->assertCount(1, $reply->likes);
    }
}
