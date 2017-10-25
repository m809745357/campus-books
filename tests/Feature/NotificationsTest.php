<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function is_an_authenticate_user_can_send_message_to_others()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $otherUser = factory('App\User')->create();

        factory('App\Models\Message')->create([
            'from_user_id' => $user->id,
            'to_user_id' => $otherUser->id,
        ]);

        $this->assertCount(1, $otherUser->fresh()->notifications);
    }

    /** @test */
    public function is_an_authenticate_user_can_chat_with_others()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $otherUser = factory('App\User')->create();

        $this->post("users/{$otherUser->id}/chat", [
            'message' => 'hello world'
        ]);

        $this->assertCount(1, $otherUser->fresh()->notifications);
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
