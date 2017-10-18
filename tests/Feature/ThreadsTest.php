<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test*/
    public function is_an_authenticate_user_can_view_all_threads()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create(['user_id' => $user->id]);

        $response = $this->get('/threads');

        $response->assertSee($thread->title);
    }

    /** @test*/
    public function is_an_authenticate_user_can_view_one_thread()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $channel = factory('App\Models\Channel')->create();

        $thread = factory('App\Models\Thread')->create(['user_id' => $user->id, 'channel_id' => $channel->id]);

        $response = $this->get("/threads/{$channel->slug}/{$thread->id}");

        $response->assertSee($thread->title);
    }


    /** @test*/
    public function is_an_authenticate_user_can_view_all_threads_to_channels()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create(['user_id' => $user->id]);

        $response = $this->get("/threads/{$thread->channel->slug}");

        $response->assertSee($thread->title);
    }

    /** @test*/
    public function is_an_authenticate_user_can_post_thread()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->make(['user_id' => $user->id]);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test*/
    public function is_an_authenticate_user_can_view_two_threads_on_home(){
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread', 10)->create();

        $reply = factory('App\Models\Reply', 20)->create(['thread_id' => $thread->first()->id, 'body' => 'it was something']);

        $this->get('/')->assertSee($thread->first()->title);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
