<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recharge;

class RechargeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 充值界面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recharges = Recharge::latest('money')->get();

        return view('users.recharges', compact('recharges'));
    }


    /**
     * 创建充值
     *
     * @param  Recharge $recharge
     * @return [type]             [description]
     */
    public function store(Recharge $recharge)
    {
        $recharge->billed(array('remark' => '充值', 'change_type' => 'increment'));
    }
}
