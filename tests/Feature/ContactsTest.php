<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ContactsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function is_an_authenticate_user_can_create_contact_after_chat()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $otherUser = factory('App\User')->create();

        $this->get("/users/{$otherUser->id}/chat");

        $this->assertDatabaseHas('contacts', ['user_id' => $user->id, 'contact_user_id' => $otherUser->id]);

        $this->assertDatabaseHas('contacts', ['user_id' => $otherUser->id, 'contact_user_id' => $user->id]);
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
