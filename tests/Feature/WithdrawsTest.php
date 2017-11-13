<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WithdrawsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function if_the_authenticate_user_has_the_balance_can_withdraw_cash()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $this->get('/withdraws')->assertStatus(302);

        $user->update(['balances' => '100']);

        $this->get('/withdraws')->assertStatus(200);
    }

    /** @test */
    public function the_amount_withdrawn_by_the_user_must_be_less_than_the_balance()
    {
        $user = factory('App\User')->create(['balances' => 1000]);

        $this->actingAs($user);

        $this->post('/withdraws', [
            'money' => 1001
        ])->assertStatus(400);

        $this->withExceptionHandling();

        $this->json('POST', 'withdraws', [
            'money' => 'not-a-money'
        ])->assertStatus(422);

        $this->json('POST', 'withdraws', [
            'money' => ''
        ])->assertStatus(422);
    }

    /** @test */
    public function the_authenticate_user_can_withdraw_now()
    {
        $user = factory('App\User')->create(['balances' => 1000]);

        $this->actingAs($user);

        $response = $this->json('POST', 'withdraws', [
            'money' => 100
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('withdraws', ['user_id' => $user->id, 'id' => $response->getData()->id]);

        $this->assertEquals(900, $user->fresh()->balances);
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
