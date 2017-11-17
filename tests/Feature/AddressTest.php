<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function is_an_authenticate_user_can_add_address()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $address = factory('App\Models\Address')->make(['user_id' => $user->id]);

        $this->json('post', '/api/address', $address->toArray());

        $this->assertDatabaseHas('addresses', ['user_id' => $user->id]);
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
