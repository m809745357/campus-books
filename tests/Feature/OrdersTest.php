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
    public function is_an_authenticate_user_can_place_an_order()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $address = factory('App\Models\Address')->create(['user_id' => $user->id]);

        $response = $this->post('/orders', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'book_detail' => $book->id,
            'address' => $address->id,
        ]);

        $this->assertDatabaseHas('orders', ['user_id' => $user->id ]);
    }

    /** @test */
    public function after_an_authenticate_user_sellers_can_close_the_transaction()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create(['user_id' => $user->id]);

        $order = factory('App\Models\Order')->create(['book_id' => $book->id, 'book_detail' => $book->id]);

        $this->post($order->path() . '/close');

        $this->assertEquals('1', $book->fresh()->status);

        $this->assertEquals('-2000', $order->fresh()->status);
    }

    /** @test */
    public function is_a_book_can_only_have_one_order()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $address = factory('App\Models\Address')->create(['user_id' => $user->id]);

        $response = $this->post('/orders', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'book_detail' => $book->id,
            'address' => $address->id,
        ]);

        $this->assertDatabaseHas('orders', ['user_id' => $user->id ]);

        $this->withExceptionHandling();
        $otherUser = factory('App\User')->create();

        $this->actingAs($otherUser);

        $response = $this->post('/orders', [
            'user_id' => $otherUser->id,
            'book_id' => $book->id,
            'book_detail' => $book->id,
            'address' => $address->id,
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function is_an_authenticated_user_can_pay_after_placing_an_order()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $address = factory('App\Models\Address')->create(['user_id' => $user->id]);

        $order = $user->addOrder([
            'book_id' => $book->id,
            'book_detail' => $book->id,
            'address' => $address->id,
        ]);

        $response = $this->get($order->path() . '/pay');

        $response->assertSee($order->book_detail->title);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_order_details_after_placing_an_order()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $address = factory('App\Models\Address')->create(['user_id' => $user->id]);

        $order = $user->addOrder([
            'book_id' => $book->id,
            'book_detail' => $book->id,
            'address' => $address->id,
        ]);

        $response = $this->get($order->path());

        $response->assertSee($order->book_detail->title);
    }

    /** @test */
    public function is_an_authenticate_user_can_cancel_the_order_after_placing_the_order()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $order = factory('App\Models\Order')->create(['user_id' => $user->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        $response = $this->post($order->path() . '/cancel');

        $this->assertEquals('1', $book->fresh()->status);

        $this->assertEquals('-1000', $order->fresh()->status);
    }

    /** @test */
    public function is_the_buyer_can_delete_the_order_after_an_authenticate_user_has_canceled_the_order()
    {
        $user = factory('App\User')->create(['balances' => 10000]);

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $order = factory('App\Models\Order')->create(['user_id' => $user->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        $order->cancel();

        $this->delete($order->path());

        $this->assertTrue($order->fresh()->trashed());

        $this->assertEquals('1', $book->fresh()->status);

        $order = factory('App\Models\Order')->create(['user_id' => $user->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        // 支付后取消订单
        $order->pay()->cancel();

        $this->delete($order->path());

        $this->assertTrue($order->fresh()->trashed());

        $this->assertEquals('1', $book->fresh()->status);
    }

    /** @test */
    public function is_the_seller_can_delete_the_order_after_an_authenticate_user_has_canceled_the_order()
    {
        $user = factory('App\User')->create();

        $buyer = factory('App\User')->create(['balances' => 10000]);

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create(['user_id' => $user->id]);

        $order = factory('App\Models\Order')->create(['user_id' => $buyer->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        // 直接取消订单
        $order->cancel();

        $this->delete($order->path());

        $this->assertTrue($order->fresh()->trashed());

        $this->assertEquals('1', $book->fresh()->status);

        $order = factory('App\Models\Order')->create(['user_id' => $buyer->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        // 支付后取消订单
        $order->pay()->cancel();

        $this->delete($order->path());

        $this->assertTrue($order->fresh()->trashed());

        $this->assertEquals('1', $book->fresh()->status);
    }

    /** @test */
    public function is_an_authenticate_user_can_use_his_balance_to_place_an_order()
    {
        $user = factory('App\User')->create(['balances' => '10000']);

        $this->actingAs($user);

        $seller = factory('App\User')->create();

        $book = factory('App\Models\Book')->create(['user_id' => $seller->id]);

        $order = factory('App\Models\Order')->create(['user_id' => $user->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        $response = $this->post($order->path() . '/pay', ['paymet' => 'balances']);

        $this->assertEquals('0100', $order->fresh()->status);

        $userBalances = $user->balances - $order->money();

        $sellerBalances = $seller->balances + $order->money();

        $this->assertEquals((int)$userBalances, $user->fresh()->balances);

        $this->assertEquals((int)$sellerBalances, $seller->fresh()->balances);
    }

    /** @test */
    public function is_an_authenticated_user_can_cancel_after_paying_the_order()
    {
        $user = factory('App\User')->create(['balances' => 10000]);

        $this->actingAs($user);

        $seller = factory('App\User')->create();

        $book = factory('App\Models\Book')->create(['user_id' => $seller->id]);

        $order = factory('App\Models\Order')->create(['user_id' => $user->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        $order->pay();

        $response = $this->post($order->path() . '/cancel');

        $this->assertEquals('-1100', $order->fresh()->status);

        $this->assertEquals('1', $book->fresh()->status);

        $this->assertEquals($user->balances, $user->fresh()->balances);

        $this->assertEquals($seller->balances, $seller->fresh()->balances);
    }

    /** @test */
    public function is_the_seller_can_be_shipped_after_the_authenticated_user_has_paid_the_order()
    {
        $user = factory('App\User')->create();

        $buyer = factory('App\User')->create(['balances' => '10000']);

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create(['user_id' => $user->id]);

        $order = factory('App\Models\Order')->create(['user_id' => $buyer->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        $order->pay();

        $express = ['company' => '顺丰', 'number' => '123456787'];

        $response = $this->post($order->path() . '/ship', $express);

        $this->assertEquals('0110', $order->fresh()->status);

        $this->assertEquals('3', $book->fresh()->status);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'express_company' => $express['company'],
            'express_number' => $express['number']
        ]);
    }

    /** @test */
    public function is_the_seller_can_close_the_transaction_after_the_order_is_paid()
    {
        $user = factory('App\User')->create();

        $buyer = factory('App\User')->create(['balances' => '10000']);

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create(['user_id' => $user->id]);

        $order = factory('App\Models\Order')->create(['user_id' => $buyer->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        $order->pay();

        $this->post($order->path() . '/close');

        $this->assertEquals('1', $book->fresh()->status);

        $this->assertEquals('-2100', $order->fresh()->status);
    }

    /** @test */
    public function is_the_buyer_confirms_the_order_after_the_seller_has_shipped_the_order()
    {
        $user = factory('App\User')->create(['balances' => 10000]);

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $order = factory('App\Models\Order')->create(['user_id' => $user->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        $order->pay()->ship();

        $this->post($order->path() . '/confirms');

        $this->assertEquals('1110', $order->fresh()->status);

        $this->assertEquals('4', $book->fresh()->status);
    }

    /** @test */
    public function is_buyers_can_be_deleted_after_the_order_is_completed()
    {
        $user = factory('App\User')->create(['balances' => 10000]);

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create();

        $order = factory('App\Models\Order')->create(['user_id' => $user->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        $order->pay()->ship()->confirms();

        $this->delete($order->path());

        $this->assertTrue($order->fresh()->trashed());
    }

    /** @test */
    public function is_seller_can_be_deleted_after_the_order_is_completed()
    {
        $user = factory('App\User')->create();

        $buyer = factory('App\User')->create(['balances' => '10000']);

        $this->actingAs($user);

        $book = factory('App\Models\Book')->create(['user_id' => $user->id]);

        $order = factory('App\Models\Order')->create(['user_id' => $buyer->id, 'book_id' => $book->id, 'book_detail' => $book->id]);

        $order->pay()->ship()->confirms();

        $this->delete($order->path());

        $this->assertTrue($order->fresh()->trashed());
    }

    /** @test */
    public function is_an_authenticate_user_can_view_onwer_order()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $order = factory('App\Models\Order')->create(['user_id' => $user->id]);

        $response = $this->json('POST', '/api/orders');

        $response->assertSee($order->book_detail->title);
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
