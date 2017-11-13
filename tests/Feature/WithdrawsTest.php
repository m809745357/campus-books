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

        $response = $this->get('/users/withdraws');

        $response->assertStatus(302);

        $recharge = factory('App\Models\Recharge')->create();

        $recharge->billed(array('remark' => '充值', 'change_type' => 'increment'));

        $response = $this->get('/users/withdraws');

        $response->assertStatus(200);
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
