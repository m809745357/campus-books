<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Thread;
use App\Models\Demand;
use App\Models\Book;
use App\Models\Carousel;
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
        $trendingThreads = resolve('ThreadTrending')->trending(2);
        $trendingDemands = resolve('DemandTrending')->trending(3);
        $trendingPbooks = Book::where(['type' => 'PBook'])->with('onwer', 'category')->where('status' , 1)->latest('views_count')->paginate(4);
        $trendingEbooks = Book::where(['type' => 'EBook'])->with('onwer', 'category')->where('status' , 1)->latest('views_count')->paginate(4);

        $carousels = Carousel::where(['type' => 'home'])->get();

        return view('home', compact('trendingThreads', 'trendingDemands', 'trendingPbooks', 'trendingEbooks', 'carousels'));

    }
}
