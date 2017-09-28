<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function is_an_authenticate_user_can_favorite_any_reply()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $reply = factory('App\Models\Reply')->create();

        $this->post($reply->path() . '/favorites');

        $this->assertCount(1, $reply->favorites);

        $this->assertEquals(1, $reply->fresh()->favorites_count);

        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'favorited_id' => $reply->id]);
    }

    /** @test*/
    public function is_an_authenticate_user_can_favorite_any_reply_once()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $reply = factory('App\Models\Reply')->create();

        $this->post($reply->path() . '/favorites');

        $this->post($reply->path() . '/favorites');

        $this->assertCount(1, $reply->favorites);

        $this->assertEquals(1, $reply->fresh()->favorites_count);

        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'favorited_id' => $reply->id]);
    }

    /** @test*/
    public function is_an_authenticate_user_can_delete_favorite_reply()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $reply = factory('App\Models\Reply')->create();

        $reply->favorited();

        $this->delete($reply->path() . '/favorites');

        $this->assertCount(0, $reply->favorites);

        $this->assertEquals(0, $reply->fresh()->favorites_count);
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
