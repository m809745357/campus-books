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
     * 创建充值
     *
     * @param  Recharge $recharge
     * @return [type]             [description]
     */
    public function store(Recharge $recharge)
    {
        $recharge->billed();
    }
}
