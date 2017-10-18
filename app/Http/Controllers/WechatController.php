<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Thread;
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

        return view('home', compact('hotThreads'));

    }
}
