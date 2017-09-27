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

        $thread = factory('App\Models\Thread')->create(['user_id' => $user->id]);

        $response = $this->get($thread->path());

        $response->assertSee($thread->title);
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
