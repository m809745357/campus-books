<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrdersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function is_an_authenticate_user_can_not_view_onwer_book_order_preview_other_can_view()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $otherUser = factory('App\User')->create();

        $book = factory('App\Models\Book')->create(['user_id' => $otherUser->id]);

        $address = factory('App\Models\Address')->create(['user_id' => $user->id]);

        $response = $this->get($book->path() . '/preview');

        $response->assertSee($book->title)->assertSee($address->user_name);

        $this->actingAs($otherUser);

        $response = $this->get($book->path() . '/preview');

        $response->assertStatus(302);
    }

    /** @test */
    public function is_an_authenticate_user_can_create_order()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $address = factory('App\Models\Address')->create(['user_id' => $user->id]);

        $response = $this->post('/orders', [
            'user_id' => $user->id,
            'book' => $book->id,
            'address' => $address->id,
        ]);

        $this->assertDatabaseHas('orders', ['user_id' => $user->id ]);
    }

    /** @test */
    public function one_book_an_create_one_order()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $address = factory('App\Models\Address')->create(['user_id' => $user->id]);

        $response = $this->post('/orders', [
            'user_id' => $user->id,
            'book' => $book->id,
            'address' => $address->id,
        ]);

        $this->assertDatabaseHas('orders', ['user_id' => $user->id ]);

        $this->withExceptionHandling();
        $otherUser = factory('App\User')->create();

        $this->actingAs($otherUser);

        $response = $this->post('/orders', [
            'user_id' => $otherUser->id,
            'book' => $book->id,
            'address' => $address->id,
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_order_pay()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $address = factory('App\Models\Address')->create(['user_id' => $user->id]);

        $order = $user->addOrder([
            'book' => $book->id,
            'address' => $address->id,
        ]);

        $response = $this->get($order->path() . '/pay');

        $response->assertSee($order->book->title);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_order_detail()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $address = factory('App\Models\Address')->create(['user_id' => $user->id]);

        $order = $user->addOrder([
            'book' => $book->id,
            'address' => $address->id,
        ]);

        $response = $this->get($order->path());

        $response->assertSee($order->book->title);
    }

    /** @test */
    public function order_can_be_cancel()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $order = factory('App\Models\Order')->create(['user_id' => $user->id, 'book' => $book->id]);

        $response = $this->post($order->path() . '/cancel');

        $this->assertEquals('1', $book->fresh()->status);

        $this->assertEquals('-1000', $order->fresh()->status);
    }

    /** @test */
    public function order_can_be_payment_for_balances()
    {
        $user = factory('App\User')->create(['balances' => '10000']);

        $this->actingAs($user);

        $order = factory('App\Models\Order')->create(['user_id' => $user->id]);

        $response = $this->post($order->path() . '/pay', ['paymet' => 'balances']);

        $this->assertEquals('0100', $order->fresh()->status);

        $balances = $user->balances - $order->book->money - $order->book->freight;

        $this->assertEquals((int)$balances, $user->fresh()->balances);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_onwer_order()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $order = factory('App\Models\Order')->create(['user_id' => $user->id]);

        $response = $this->json('POST', '/api/orders');

        $response->assertSee($order->book->title);
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
