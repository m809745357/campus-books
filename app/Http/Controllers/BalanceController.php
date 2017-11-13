<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 我的余额
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $balances = auth()->user()->balances;

        return view('users.balances', compact('balances'));
    }
}
