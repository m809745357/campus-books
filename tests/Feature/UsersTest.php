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

        $response = $this->get('/login');

        $response->assertStatus(302);

        $response->assertSee(config('wechat.app_id'));
    }

    /** @test*/
    public function a_user_logs_on_for_the_second_time()
    {
        $response = $this->get('/login');

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
    public function is_an_authenticate_user_can_view_user_center()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $response = $this->get('/users/');

        $response->assertStatus(200);

        $response->assertSee($user->nickname);
    }

    /** @test*/
    public function is_an_authenticate_user_can_view_user_profile()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $response = $this->get('/users/profile');

        $response->assertStatus(200);

        $response->assertSee($user->nickname)
            ->assertSee($user->school)
            ->assertSee($user->specialty);
    }

    /** @test*/
    public function is_an_authenticate_user_can_send_code_message()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $response = $this->json('post', '/users/sendmobile', [
            'mobile' => '18367831980'
        ]);

        $response->assertStatus(201)->assertJson([
            'code' => '666666',
        ]);

        $this->withExceptionHandling();
        $response = $this->json('post', '/users/sendmobile', [
            'mobile' => null
        ]);

        $response->assertStatus(422)->assertJson(['message' => 'The given data was invalid.']);
    }

    /** @test */
    public function is_an_authenticate_user_can_bind_mobile()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $response = $this->json('post', '/users/sendmobile', [
            'mobile' => '18367831980'
        ]);

        $response->assertStatus(201)->assertJson([
            'code' => '666666',
        ]);

        $response = $this->json('post', '/users/bindmobile', [
            'mobile' => '18367831980',
            'code' => '666666'
        ]);

        $this->assertTrue($user->fresh()->mobile === '18367831980');
    }

    /** @test */
    public function is_an_authenticate_user_can_update_profile()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $response = $this->json('put', '/users', [
            'nickname' => '沈一飞',
            'school' => '浙江工贸职业技术学院',
            'specialty' => '软件技术'
        ]);

        $response->assertStatus(201);

        $this->assertTrue($user->fresh()->school === '浙江工贸职业技术学院');
        $this->assertTrue($user->fresh()->specialty === '软件技术');
    }

    /** @test */
    public function is_an_authenticate_user_can_validate_mobile()
    {
        $user = factory('App\User')->create();

        $this->actingAs($user);

        $user->mobile = '18367831980';
        $user->save();
        $response = $this->json('post', '/users/validatemobile', [
            'mobile' => $user->mobile,
            'code' => '666666'
        ]);

        $response->assertStatus(201)->assertJson([
            'validate' => true,
        ]);
    }
}
