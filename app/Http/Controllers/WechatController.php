<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Thread;
use App\Models\Demand;
use App\Models\Book;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    public function __construct()
    {

    }
    /**
     * home
     * @param  Application $app wechat
     * @return [type]           [description]
     */
    public function index(Thread $thread)
    {
        $trendingThreads = resolve('ThreadTrending')->trending(2);
        $trendingDemands = resolve('DemandTrending')->trending(3);
        $trendingPbooks = resolve('BookTrending')->trending(6, ['type' => 'PBook']);
        $trendingEbooks = resolve('BookTrending')->trending(6, ['type' => 'EBook']);

        return view('home', compact('trendingThreads', 'trendingDemands', 'trendingPbooks', 'trendingEbooks'));

    }
}
