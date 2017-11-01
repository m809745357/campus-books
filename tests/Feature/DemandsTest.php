<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DemandsTest extends TestCase
{

    use DatabaseMigrations;
    /** @test */
    public function is_an_authenticate_user_can_view_all_demands()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $demands = factory('App\Models\Demand')->create();

        $response = $this->get('/demands');

        $response->assertSee($demands->title);
    }

    /** @test */
    public function is_an_authenticate_user_can_view_one_demands()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $demands = factory('App\Models\Demand')->create();

        $response = $this->get($demands->path());

        $this->assertEquals(1, $demands->fresh()->views_count);
    }

    /** @test*/
    public function is_an_authenticate_user_can_view_hot_demands_on_home()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $demands = factory('App\Models\Demand', 10)->create();

        $demands->first()->increment('views_count', 20);

        $this->get('/')->assertSee($demands->first()->title);
    }

    /** @test*/
    public function is_an_authenticate_user_can_create_demand()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $demand = factory('App\Models\Demand')->make(['user_id' => $user->id]);

        $response = $this->post('/demands', $demand->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($demand->title)
            ->assertSee($demand->body);
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
