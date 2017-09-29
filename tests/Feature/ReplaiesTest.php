<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplaiesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function is_an_authenticate_user_can_view_one_thread_all_replaies()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create(['user_id' => $user->id]);

        $reply = factory('App\Models\Reply')->create(['thread_id' => $thread->id]);

        $this->assertDatabaseHas('threads', ['id' => $thread->id, 'replies_count' => 1]);

        $response = $this->get($thread->path());

        $response->assertSee($reply->body);
    }

    /** @test*/
    public function is_an_authenticate_user_can_reply_any_thread()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create(['user_id' => $user->id]);

        $response =$this->json('POST', $thread->path() . '/reply', [
            'body' => 'it was something'
        ]);

        $response->assertStatus(201)->assertJson([
            'body' => 'it was something',
        ]);

        $this->assertDatabaseHas('threads', ['id' => $thread->id, 'replies_count' => 1]);

        $this->assertDatabaseHas('replies', ['thread_id' => $thread->id, 'user_id' => $user->id, 'body' => 'it was something']);
    }

    /** @test*/
    public function is_an_authenticate_user_can_delete_onwer_reply()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create();

        $reply = $thread->addReply('it was something');

        $this->delete($reply->path());

        $this->assertTrue($thread->fresh()->replies_count == 0);

        $this->assertDatabaseMissing('replies', ['user_id' => $user->id, 'thread_id' => $thread->id, 'body' => 'it was something']);
    }

    /** @test*/
    public function is_an_authenticate_user_can_not_delete_belong_to_other_reply()
    {
        $this->withExceptionHandling();

        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create();

        $reply = factory('App\Models\Reply')->create(['thread_id' => $thread->id]);

        $this->delete($reply->path());

        $this->assertDatabaseHas('replies', ['id' => $reply->id]);
    }

    /** @test*/
    public function guest_can_not_delete_reply()
    {
        $this->withExceptionHandling();

        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create();

        $reply = factory('App\Models\Reply')->create(['thread_id' => $thread->id, 'body' => 'it was something']);

        $repsonse = $this->delete($reply->path());

        $repsonse->assertStatus(403);
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
