<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Thread;
use App\Models\Demand;
use App\Models\Book;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    /**
     * home
     * @param  Application $app wechat
     * @return [type]           [description]
     */
    public function index()
    {
        $minutes = 60 * 60;

        $trendingThreads = \Cache::remember('threads.trending', $minutes, function () {
            return Thread::hot(2);
        });

        $trendingDemands = \Cache::remember('demands.trending', $minutes, function () {
            return Demand::hot(3);
        });

        $trendingPbooks = \Cache::remember('books.trending.pbook', $minutes, function () {
            return Book::hot(6, ['type' => 'PBook']);
        });

        $trendingEbooks = \Cache::remember('books.trending.ebook', $minutes, function () {
            return Book::hot(6, ['type' => 'EBook']);
        });

        return view('home', compact('trendingThreads', 'trendingDemands', 'trendingPbooks', 'trendingEbooks'));

    }
}
