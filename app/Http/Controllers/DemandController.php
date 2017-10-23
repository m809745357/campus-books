<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    /**
     * 我的求购列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demands = Demand::latest()->get();
        return view('demands.index', compact('demands'));
    }

    /**
     * 单个求购详情
     *
     * @param  Demand $demand
     * @return \Illuminate\Http\Response
     */
    public function show(Demand $demand)
    {
        $demand->increment('views_count');
        $demand = $demand->load('onwer');
        return view('demands.show', compact('demand'));
    }
}
