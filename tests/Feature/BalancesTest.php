<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BalancesTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function is_an_authenticate_user_can_view_balances()
    {
        $user = factory('App\User')->create(['balances' => '1980']);

        $this->actingAs($user);

        $response = $this->get('/users/balances');

        $response->assertSee($user->balances);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_all_recharges()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $recharge = factory('App\Models\Recharge')->create();

        $response = $this->get('/users/recharges');

        $response->assertSee((string)$recharge->money);
    }

    /** @test */
    public function is_an_authenticate_user_can_recharge_balances()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $recharge = factory('App\Models\Recharge')->create();

        $this->post("/recharge/{$recharge->id}/bill");

        $this->assertDatabaseHas('bills', ['user_id' => $user->id, 'billed_id' => $recharge->id, 'billed_type' => 'App\Models\Recharge']);

        $this->assertEquals($user->balances + $recharge->money, $user->fresh()->balances);
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
