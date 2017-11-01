<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use App\Http\Requests\StoreDemandPost;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }
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

    public function create()
    {
        return view('demands.create');
    }

    public function store(StoreDemandPost $request)
    {
        $demand = auth()->user()->demands()->create($request->validated());

        if (request()->wantsJson()) {
            return response($demand, 201);
        }

        return redirect($demand->path());
    }
}
