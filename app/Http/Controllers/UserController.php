<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Filters\FavoriteFilters;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 用户首页
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * 用户个人资料
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }

    /**
     * 我的收藏
     *
     * @param  FavoriteFilters $filters 过滤函数
     * @return \Illuminate\Http\Response
     */
    public function favorites(FavoriteFilters $filters)
    {
        $favorites = auth()->user()->favorited($filters);
        return view('users.favorites', compact('favorites'));
    }

    /**
     * 我的提问
     *
     * @return \Illuminate\Http\Response
     */
    public function threads()
    {
        $threads = auth()->user()->threads()->with('onwer', 'channel')->latest()->get();

        return view('users.threads', compact('threads'));
    }

    /**
     * 我的回答
     *
     * @return \Illuminate\Http\Response
     */
    public function replies()
    {
        $replies = auth()->user()->replies()->with('onwer', 'thread', 'thread.channel')->latest()->get();

        return view('users.replies', compact('replies'));
    }

    public function demands()
    {
        $demands = auth()->user()->demands()->latest()->get();

        return view('users.demands', compact('demands'));
    }

    /**
     * 绑定手机号码
     * @param  Request $request 用户请求
     * @return App\User $user
     */
    public function mobile(Request $request)
    {
        $data = $request->validate([
            'mobile' => 'required',
            'code' => 'required'
        ]);

        $user = auth()->user();
        $user->mobile = $request->mobile;
        $user->save();
    }
}
