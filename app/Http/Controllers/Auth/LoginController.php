<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use EasyWeChat\Foundation\Application;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm(Application $app)
    {
        $user = $this->createUserAndLogin();

        if (! session()->has('wechat.oauth_user')) {
            $response = $app->oauth->scopes(['snsapi_userinfo'])
                                      ->redirect();

            return $response;
        }

        // return view('auth.login');
        if (! $user->mobile) {
            return redirect()->route('bind.mobile');
        }

        return redirect('/users');
    }

    /**
     * WeChat Auth
     * @param  Application $app wechat
     * @return redirect         goto /
     */
    public function oauthCallback(Application $app)
    {
        if (app()->environment('testing')) {
            if (! session()->has('wechat.oauth_user')) {
                $user = $app->oauth->user();
            } else {
                $user = session()->get('wechat.oauth_user');
            }
        } else {
            $user = $app->oauth->user();
            $request->session(['wechat.oauth_user' => $user]);
        }

        return redirect('/');
    }

    /**
     * create user
     * @return App/User $user
     */
    protected function createUserAndLogin()
    {
        $oauthUser = session()->get('wechat.oauth_user');

        if (! User::where(['openid' => $oauthUser->id])->exists()) {
            $user = User::create([
                'nickname' => $oauthUser->nickname,
                'name' => $oauthUser->name,
                'email' => $oauthUser->email,
                'avatar' => $oauthUser->avatar,
                'openid' => $oauthUser->id,
                'sex' => $oauthUser->original['sex'],
                'password' => bcrypt('huishuoit'),
            ]);
        } else {
            $user = User::where(['openid' => $oauthUser->id])->firstOrFail();
        }

        \Auth::login($user);

        return $user;
    }
}
