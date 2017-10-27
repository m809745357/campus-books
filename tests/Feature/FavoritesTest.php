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

        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'favorited_id' => $reply->id, 'favorited_type' => 'App\Models\Reply']);
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

        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'favorited_id' => $reply->id, 'favorited_type' => 'App\Models\Reply']);
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

    /** @test*/
    public function is_an_authenticate_user_can_favorite_any_threads()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create();

        $this->post($thread->path() . '/favorites');

        $this->assertCount(1, $thread->favorites);

        $this->assertEquals(1, $thread->fresh()->favorites_count);

        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'favorited_id' => $thread->id, 'favorited_type' => 'App\Models\Thread']);
    }

    /** @test*/
    public function is_an_authenticate_user_can_favorite_any_threads_once()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create();

        $this->post($thread->path() . '/favorites');

        $this->post($thread->path() . '/favorites');

        $this->assertCount(1, $thread->favorites);

        $this->assertEquals(1, $thread->fresh()->favorites_count);

        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'favorited_id' => $thread->id, 'favorited_type' => 'App\Models\Thread']);
    }

    /** @test*/
    public function is_an_authenticate_user_can_delete_favorite_thread()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create();

        $thread->favorited();

        $this->delete($thread->path() . '/favorites');

        $this->assertCount(0, $thread->favorites);

        $this->assertEquals(0, $thread->fresh()->favorites_count);
    }

    /** @test*/
    public function is_an_authenticate_user_can_favorite_any_books()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $this->post($book->path() . '/favorites');

        $this->assertCount(1, $book->favorites);

        $this->assertEquals(1, $book->fresh()->favorites_count);

        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'favorited_id' => $book->id, 'favorited_type' => 'App\Models\Book']);
    }

    /** @test*/
    public function is_an_authenticate_user_can_favorite_any_books_once()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $this->post($book->path() . '/favorites');

        $this->post($book->path() . '/favorites');

        $this->assertCount(1, $book->favorites);

        $this->assertEquals(1, $book->fresh()->favorites_count);

        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'favorited_id' => $book->id, 'favorited_type' => 'App\Models\Book']);
    }

    /** @test*/
    public function is_an_authenticate_user_can_delete_favorite_book()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $book->favorited();

        $this->delete($book->path() . '/favorites');

        $this->assertCount(0, $book->favorites);

        $this->assertEquals(0, $book->fresh()->favorites_count);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_onwer_favorites()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $thread = factory('App\Models\Thread')->create();

        $thread->favorited();

        $response = $this->get("/users/favorites/thread");
        $response->assertSee($thread->title);

        $book = factory('App\Models\Book')->create();

        $book->favorited();

        $response = $this->get("/users/favorites/book");

        $response->assertSee($book->title);
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
