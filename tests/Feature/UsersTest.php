<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test*/
    public function a_user_logs_in_for_the_first_time()
    {
        session()->forget('wechat.oauth_user');
        config(['wechat.enable_mock' => false]);

        $response = $this->get('/');

        $response->assertStatus(302);

        $response->assertSee(config('wechat.app_id'));
    }

    /** @test*/
    public function a_user_logs_on_for_the_second_time()
    {
        $response = $this->get('/');

        $user = session()->get('wechat.oauth_user');

        if (! $user->mobile) {
            $response->assertStatus(302);
        }

    }

    /** @test*/
    public function a_user_no_through_wechat_authorized_to_log()
    {
        session()->forget('wechat.oauth_user');
        config(['wechat.enable_mock' => false]);

        $this->withExceptionHandling();

        $response = $this->get('/oauth_callback');

        $response->assertSee('missing code');
    }

    /** @test*/
    public function a_user_through_wechat_authorized_to_log()
    {
        $response = $this->get('/oauth_callback');

        $response->assertStatus(302);

        $this->assertTrue(session()->has('wechat.oauth_user'));

        $user = session()->get('wechat.oauth_user');
    }

    /** @test*/
    public function is_an_authenticate_user_can_view_user_profile()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $response = $this->get('/users/' . $user->id);

        $response->assertStatus(200);
    }

    /** @test*/
    public function is_an_authenticate_user_can_view_other_user_profile()
    {
        $user = factory('App\User')->create();

        $othreUser = factory('App\User')->create();

        $this->actingAs($user);

        $response = $this->get('/users/' . $user->id);

        $response = $this->get('/users/' . $othreUser->id);

        $response->assertStatus(302);
    }
}
