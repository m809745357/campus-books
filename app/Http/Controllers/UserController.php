<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Recharge;

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

    /**
     * 我的求购
     *
     * @return \Illuminate\Http\Response
     */
    public function demands()
    {
        $demands = auth()->user()->demands()->latest()->get();

        return view('users.demands', compact('demands'));
    }

    /**
     * 我的余额
     *
     * @return \Illuminate\Http\Response
     */
    public function balances()
    {
        $balances = auth()->user()->balances;

        return view('users.balances', compact('balances'));
    }

    /**
     * 充值界面
     *
     * @return \Illuminate\Http\Response
     */
    public function recharges()
    {
        $recharges = Recharge::latest('money')->get();

        return view('users.recharges', compact('recharges'));
    }

    /**
     * 消费记录
     *
     * @return \Illuminate\Http\Response
     */
    public function bills()
    {
        $bills = auth()->user()->bills->load('billed');

        return view('users.bills', compact('bills'));
    }

    /**
     * 我的发布
     *
     * @return \Illuminate\Http\Response
     */
    public function books()
    {
        $books = auth()->user()->books->load('category');
        return view('users.books', compact('books'));
    }

    /**
     * 我的订单
     *
     * @return \Illuminate\Http\Response
     */
    public function orders()
    {
        if (request()->wantsJson()) {
            $orders = auth()->user()->orders;
            return response($orders, 200);
        }

        $books = auth()->user()->books->load('category');
        return view('users.orders', compact('books'));
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
