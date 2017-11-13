<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreWithdrawPost;

class WithdrawController extends Controller
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
     * 提现
     * @return [type] [description]
     */
    public function index()
    {
        if (! auth()->user()->balances > 0) {
            return back();
        }

        return view('users.withdraws');
    }

    /**
     * 创建提现
     *
     * @param  StoreWithdrawPost $request [description]
     * @return [type]                     [description]
     */
    public function store(StoreWithdrawPost $request)
    {
        $withdraw = auth()->user()->addWithdraw($request->validated());

        if (! $withdraw) {
            return response('提现失败', 400);
        }

        return $withdraw;
    }
}
