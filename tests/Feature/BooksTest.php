<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BooksTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function is_an_authenticate_user_can_view_all_books()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $books = factory('App\Models\Book')->create();

        $response = $this->get('/books');

        $response->assertSee($books->title);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_any_book()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $response = $this->get($book->path());

        $response->assertSee($book->title);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_post_books()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create(['user_id' => $user->id]);

        $response = $this->get('/users/books');

        $response->assertSee($book->title);
    }

    /** @test */
    public function is_an_authenticate_user_can_create_book()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->make(['user_id' => $user->id]);

        $response = $this->post('books', $book->toArray());
// dd($book->toArray(), $response->headers->get('Location'));
        $this->get($response->headers->get('Location'))
            ->assertSee($book->title)
            ->assertSee($book->body);
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
