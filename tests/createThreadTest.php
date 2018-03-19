<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class createThreadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseTransactions;

   	public function testGuestUserCanNotPublishThread()
   	{
   		$this->visit('/threads/create')
           ->assertRedirectedTo('/login');
   	}

    public function testAuthenticatedUserCanPublishThread()
    {
    	$user   = factory('App\User')->create();

    	$this->actingAs($user);

    	$thread = factory('App\Thread')->make(['title' => null]);

    	$response = $this->post('/threads', $thread->toArray());

    	$this->assertSessionHasErrors();


    }

    public function testThreadRequiresTitle()
    {

      $this->publishThread(['title' => null]);



      $this->assertSessionHasErrors();
    }

    public function testThreadRequiresBody()
    {
      $this->publishThread(['body' => null]);

      $this->assertSessionHasErrors();

    }

    public function testThreadRequiresValidChannel()
    {
      $this->publishThread(['channel_id' => 999999]);

      $this->assertSessionHasErrors();
    }

    private function publishThread($overrides = [])
    {
      $this->actingAs(factory('App\User')->create());

      $thread = factory('App\Thread')->make($overrides);

      //dd($thread);
      $this->post('/threads', $thread->toArray());
    }
}
