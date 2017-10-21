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
        $hotThreads = Thread::hot(2);
        $hotDemands = Demand::hot(3);
        $hotPbooks = Book::hot(6, ['type' => 'PBook']);
        $hotEbooks = Book::hot(6, ['type' => 'EBook']);

        return view('home', compact('hotThreads', 'hotDemands', 'hotPbooks', 'hotEbooks'));

    }
}
