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

        $replay = factory('App\Models\Reply')->create(['thread_id' => $thread->id]);

        $this->assertDatabaseHas('threads', ['id' => $thread->id, 'replies_count' => 1]);

        $response = $this->get($thread->path());

        $response->assertSee($replay->body);
    }

    /** @test*/
    public function is_an_authenticate_user_can_reply_any_thread()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create();

        $response =$this->json('POST', $thread->path() . '/reply', [
            'body' => 'it was something'
        ]);

        $response->assertStatus(201)->assertJson([
            'body' => 'it was something',
        ]);

        $this->assertDatabaseHas('threads', ['id' => $thread->id, 'replies_count' => 1]);

        $this->assertDatabaseHas('replies', ['thread_id' => $thread->id, 'user_id' => $user->id, 'body' => 'it was something']);
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
