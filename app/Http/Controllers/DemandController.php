<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    public function index()
    {
        $demands = Demand::latest()->get();
        return view('demands.index', compact('demands'));
    }

    public function show(Demand $demand)
    {
        $demand->increment('views_count');
        $demand = $demand->load('onwer');
        return view('demands.show', compact('demand'));
    }
}
