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

        $this->get("users/{$otherUser->id}/chat");
        $this->post("users/{$otherUser->id}/chat", [
            'message' => 'hello world'
        ]);

        $this->assertCount(2, $otherUser->fresh()->notifications);

        $this->assertDatabaseHas('contacts', ['message' => 'hello world']);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_all_notifications()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $otherUser = factory('App\User')->create();

        $user->addContacts($otherUser);

        $otherUser->addContacts($user);

        $this->post("users/{$otherUser->id}/chat", [
            'message' => 'hello world'
        ]);

        $response = $this->get('/users/notifications');

        $response->assertSee($user->nickname);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_one_notification()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $otherUser = factory('App\User')->create();

        $otherUser->messages()->create([
            'from_user_id' => auth()->id(),
            'message' => 'my name is shen yi fei'
        ]);

        $this->assertCount(1, $otherUser->fresh()->notifications);

        $response = $this->get("/users/$otherUser->id/chat");

        $response->assertSee('my name is shen yi fei');
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
