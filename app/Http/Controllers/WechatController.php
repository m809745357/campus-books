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
        $this->middleware('auth')->except('index');
    }
    /**
     * home
     * @param  Application $app wechat
     * @return [type]           [description]
     */
    public function index(Thread $thread)
    {
        return Book::all();
        // dd(Book::where('title', 'totam')->searchable());

        $trendingThreads = resolve('ThreadTrending')->trending(2);
        $trendingDemands = resolve('DemandTrending')->trending(3);
        $trendingPbooks = Book::where(['type' => 'PBook'])->with('onwer', 'category')->latest('views_count')->paginate(6);
        $trendingEbooks = Book::where(['type' => 'EBook'])->with('onwer', 'category')->latest('views_count')->paginate(6);

        return view('home', compact('trendingThreads', 'trendingDemands', 'trendingPbooks', 'trendingEbooks'));

    }
}
