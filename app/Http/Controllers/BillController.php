<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recharge;

class BillController extends Controller
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
     * 消费记录
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = auth()->user()->bills()->with('billed')->latest()->get();

        return view('users.bills', compact('bills'));
    }
}
