<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChannelsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function is_an_authenticate_user_can_view_all_threads_channels()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $channels = factory('App\Models\Channel')->create();

        $response = $this->get('/threads/channels');

        $response->assertSee($channels->slug);
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
