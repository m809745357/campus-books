<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use App\User;

class WechatController extends Controller
{
    /**
     * home
     * @param  Application $app wechat
     * @return [type]           [description]
     */
    public function index(Application $app)
    {
        if (! session()->has('wechat.oauth_user')) {
            $response = $app->oauth->scopes(['snsapi_userinfo'])
                                      ->redirect();

            return $response;
        }

        $user = $this->createUserAndLogin();

        if (! $user->mobile) {
            return redirect()->route('bind.mobile', ['user' => $user->id]);
        }

        return view('home');

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

        $user = User::create([
            'nickname' => $oauthUser->nickname,
            'name' => $oauthUser->name,
            'email' => $oauthUser->email,
            'avatar' => $oauthUser->avatar,
            'openid' => $oauthUser->id,
            'sex' => $oauthUser->original['sex'],
            'password' => bcrypt('huishuoit'),
        ]);

        \Auth::login($user);

        return $user;
    }
}
